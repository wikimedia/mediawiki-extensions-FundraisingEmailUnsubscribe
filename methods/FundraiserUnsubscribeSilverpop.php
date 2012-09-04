<?php
/**
 * -- License --
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @file
 */

/**
 * Handler for unsubscribe links sent by SilverPop - ie the annoying emails we send begging for
 * money at the start of new fundraising campaigns :)
 */
class FundraiserUnsubscribeSilverpop
	extends UnsubscribeMethod {

	private $remoteActionEnvelope = array( 'Envelope', 'Body' );
	private $remoteActionMap = array(
		'Login' => array(
			'out' => array(
				'USERNAME' => 'username',
				'PASSWORD' => 'password',
			),
			'in' => 'processRemoteAction',
		),

		'Logout' => array(
			'out' => array(),
			'in' => 'processRemoteAction',
		),

		'OptOutRecipient' => array(
			'out' => array(
				'LIST_ID' => 'list-id',
				'MAILING_ID' => 'mailing-id',
				'RECIPIENT_ID' => 'recipient-id',
				'JOB_ID' => 'job-id',
			),
			'in' => 'processRemoteAction',
		),
	);

	private $currentParams = array();

	public function __construct() {
		$this->addRequiredParameter( 'mailing-id', '/[0-9]*/' );
		$this->addRequiredParameter( 'job-id', '/[a-zA-Z0-9]*/' );
		$this->addRequiredParameter( 'recipient-id', '/[a-zA-Z0-9]*/' );
		$this->addRequiredParameter( 'list-id', '/[0-9]*/' );
		$this->addRequiredParameter( 'hash', '/[a-zA-Z0-9]*/' );
		$this->addRequiredParameter( 'email', '/.*@.*/' );
	}

	public function unsubscribe( $requestID, $process, array $params ) {
		global $wgFundraiserUnsubscribeSilverpopUsername, $wgFundraiserUnsubscribeSilverpopPassword;
		global $wgFundraiserUnsubscribeSilverpopTimeout, $wgFundraiserUnsubscribeSilverpopURL;

		Logger::pushLabel( 'Silverpop' );
		$retval = false;

		// Create transaction object
		$txnObj = new XmlTransactionProcessor();
		$txnObj->setEndpointURL( $wgFundraiserUnsubscribeSilverpopURL );
		$txnObj->setTimeout( $wgFundraiserUnsubscribeSilverpopTimeout );
		$txnObj->setEnvelope( $this->remoteActionEnvelope );
		$txnObj->setTransactionMap( $this->remoteActionMap );

		// Do the transaction chain
		$outParamsLogin = array(
			'username' => $wgFundraiserUnsubscribeSilverpopUsername,
			'password' => $wgFundraiserUnsubscribeSilverpopPassword,
		);

		if ( $txnObj->doTransaction( 'Login', $this, $outParamsLogin ) &&
			 $txnObj->doTransaction( 'OptOutRecipient', $this, $params ) &&
			 $txnObj->doTransaction( 'Logout', $this )
		) {
			// Success!
			Logger::log( 'Unsubscribe process success!' );
			$retval = true;
		} else {
			// Failure :(
			Logger::log( 'Unsubscribe process failed!' );
			$retval = false;
		}

		// Clean up and return
		Logger::popLabel();
		return $retval;
	}

	/**
	 * Callback function from doTransaction()
	 *
	 * @param                         $txnName
	 * @param DOMDocument             $dom
	 * @param XmlTransactionProcessor $processObj
	 *
	 * @return bool
	 * @throws MWException
	 */
	public function processRemoteAction(
		$txnName,
		DOMDocument $dom,
		XmlTransactionProcessor &$processObj
	) {
		global $wgFundraiserUnsubscribeSilverpopURL;

		$retval = false;

		Logger::log( "got data back: " . $dom->saveXML() );

		// Determine if the success node is good
		$nodes = $dom->getElementsByTagName( 'SUCCESS' );
		foreach ( $nodes as $node ) {
			$nv = strtolower( $node->nodeValue );
			if ( ( $nv != 'true' ) && ( $nv != 'success' ) ) {
				return false;
			}
		}

		switch ( $txnName ) {
			case 'Login':
				$nodes = $dom->getElementsByTagName( 'SESSIONID' );
				if ( $nodes->length != 1 ) {
					throw new MWException( 'Could not extract Silverpop session ID.' );
				}

				// Get the jsessionid and validate it
				$matches = array();
				$sessionId = $nodes->item(0)->nodeValue;
				if ( preg_match( '/^[0-9a-zA-Z]+$/', $sessionId, $matches )
					 && ( $matches[0] !== '' )
				) {
					$sessionId =  $matches[0];
				} else {
					Logger::log( "Session ID failed validation! Provided was ($sessionId)", LOG_ALERT );
					$retval = false;
					break;
				}

				// Change the API endpoint URL to include the session ID
				$url = $wgFundraiserUnsubscribeSilverpopURL . ';jsessionid=' . $sessionId;
				Logger::log( "Changing URL to: $url" );
				$processObj->setEndpointURL( $url );
				$retval = true;
				break;

			case 'ListRecipientMailings':
				$nodes = $dom->getElementsByTagName( 'MailingId ' );
				foreach ( $nodes as $node ) {
					if ( $node->nodeValue == $this->currentParams['mailing-id'] ) {
						$retval = true;
					}
				}
				break;

			case 'Logout':
				// Remove the jsessionid from the API url.
				$url = $wgFundraiserUnsubscribeSilverpopURL;
				Logger::log( "Changing URL to: $url" );
				$processObj->setEndpointURL( $url );
				$retval = true;
				break;

			default:
				$retval = true;
				break;
		}

		return $retval;
	}

	/**
	 * Decodes an email address that has been sent to us from SilverPop. It turns out they don't
	 * URL encode these things; so ... ugh...
	 *
	 * TODO: Handle crazy characters, you know, like # (which breaks PHP) grumble
	 *
	 * @static
	 *
	 * @param array $params
	 *
	 * @return mixed|string
	 */
	public static function decodeEmail( array $params ) {
		$email = urldecode( $params['e'] );
		$email = str_replace( ' ', '+', $email );

		return $email;
	}
}
