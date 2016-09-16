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
 * Handler for unsubscribe links sent by the ThankYou handler (IE: sent right after they make a
 * donation.)
 */
class FundraiserUnsubscribeThankYou
	extends UnsubscribeMethod
	implements IUnsubscribeValidator {

	public function __construct() {
		$this->addRequiredParameter( 'email', '/.*@.*/' );
		$this->addRequiredParameter( 'hash', '/[a-zA-Z0-9]*/' );
		$this->addRequiredParameter( 'contribution-id', '/[0-9]*/' );
	}

	public function getRequiredValidationParameters() {
		return $this->mRequiredParameters;
	}

	public function validateRequest( array $params ) {
		global $wgFundraisingEmailUnsubscribeHashSecretKey;

		Logger::pushLabel( 'UnsubThankYou' );

		$email = $params['email'];
		$contributionId = $params['contribution-id'];
		$hash = strtolower( $params['hash'] );

		// We can only verify the hash
		$computedHash = hash( 'sha1', $contributionId . $email . $wgFundraisingEmailUnsubscribeHashSecretKey );
		if ( $computedHash != $hash ) {
			Logger::log( "Hash verification failed! Expected '$computedHash' got '$hash'.", LOG_NOTICE );

			Logger::popLabel();
			return false;
		} else {
			Logger::log( "Hash verification success!" );
		}

		// Clean up and return
		Logger::popLabel();
		return true;
	}

	public function unsubscribe( $requestID, $process, array $params ) {
		global $wgFundraisingEmailUnsubscribeQueueClass,
			   $wgFundraisingEmailUnsubscribeQueueParameters;

		Logger::pushLabel( 'UnsubThankYou' );

		$email = $params['email'];
		$contribId = $params['contribution-id'];

		$message = array(
			'process' => $process,
			'email' => $email,
			'contribution-id' => $contribId
		);
		// Send to the queue
		Logger::log( 'Placing message in queue for email ' . json_encode( $email ) );

		if ( empty( $wgFundraisingEmailUnsubscribeQueueParameters['queue'] ) ) {
			$wgFundraisingEmailUnsubscribeQueueParameters['queue'] = 'unsubscribe';
		}
		$queue = new $wgFundraisingEmailUnsubscribeQueueClass(
			$wgFundraisingEmailUnsubscribeQueueParameters
		);
		// Throws exception if it is unsuccessful
		$queue->push( $message );

		// Clean up and return
		Logger::popLabel();
		return true;
	}

	/**
	 * The ThankYou module URL encodes emails; so we need to decode the parameter to get the result
	 * @static
	 *
	 * @param array $params Expects 'e' - a URL encoded email
	 *
	 * @return string Decoded email
	 */
	public static function decodeEmail( array $params ) {
		return rawurldecode( $params['e'] );
	}
}
