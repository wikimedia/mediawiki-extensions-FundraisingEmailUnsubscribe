<?php
/**
 * STOMP utilities :)
 *
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
 * Hides some of the nitty gritty of managing the two types of STOMP libraries we could be using.
 */
class FundraiserUnsubscribeStompAdapter {

	private static $sInstance = null;
	protected $mConn = null;

	protected function __construct() {
		global $wgStompServer;

		// Factory to create whatever wrapper we need
		if ( class_exists( 'Stomp' ) ) {
			if ( is_callable( 'Stomp', 'connect' ) ) {
				$this->mConn = new FundraiserUnsubscribePhpStompWrapper( $wgStompServer );
			} else {
				$this->mConn = new FundraiserUnsubscribePeclStompWrapper( $wgStompServer );
			}
		} else {
			throw new Exception( 'No STOMP class registered :(' );
		}
	}

	/**
	 * Queues a message on the STOMP server
	 * @static
	 *
	 * @param mixed  $message         Any arbitrary message. Should be JSONable.
	 * @param string $queue           The queue name to place the message in
	 * @param string $correlation_id  Something to select this message by later
	 *
	 * @return mixed True if it was successful. Can throw exceptions :)
	 */
	public static function sendMessage( $message, $queue, $correlation_id = null ) {
		if ( static::$sInstance == null ) {
			static::$sInstance = new FundraiserUnsubscribeStompAdapter();
		}

		$properties = array();
		if ( $correlation_id != null ) {
			$properties['correlation-id'] = $correlation_id;
		}

		return static::$sInstance->mConn->sendMessage( $message, $queue, $properties );
	}
}

interface IFundraiserUnsubscribeStompWrapper {
	public function __construct( $serverURI );

	public function __destruct();

	public function sendMessage( $message, $queue, $properties = array() );
}

class FundraiserUnsubscribePhpStompWrapper implements IFundraiserUnsubscribeStompWrapper {

	private $mConn;

	public function __construct( $serverURI ) {
		$this->mConn = new Stomp( $serverURI );
		$this->mConn->connect();
	}

	public function __destruct() {
		$this->mConn->disconnect();
	}

	public function sendMessage( $message, $queue, $properties = array() ) {
		if ( !array_key_exists( 'persistent', $properties ) ) {
			$properties['persistent'] = 'true';
		}

		$msgText = json_encode( $message );
		$result = $this->mConn->send( "/queue/$queue", $msgText, $properties );

		if ( !$result ) {
			Logger::logEx( $ex, "Could not queue message to queue '$queue', msg->$msgText'" );
			return false;
		}

		return true;
	}
}

class FundraiserUnsubscribePeclStompWrapper implements IFundraiserUnsubscribeStompWrapper  {
	private $mConn;
	private $mTxCount = 0;

	public function __construct( $serverURI ) {
		$this->mConn = new Stomp( $serverURI );
	}

	public function __destruct() {
		if ( $this->mConn->isConnected() ) {
			$this->mConn->abort();
		}
	}

	public function sendMessage( $message, $queue, $properties = array() ) {
		$txid = $this->mConn->getSessionId() . '-' . ( $this->mTxCount++ );

		if ( !array_key_exists( 'persistent', $properties ) ) {
			$properties['persistent'] = 'true';
		}

		$msgText = json_encode( $message );

		try {
			$this->mConn->begin( $txid );
			$this->mConn->send( "/queue/$queue", $msgText, $properties );
			$this->mConn->commit( $txid );
		} catch ( Exception $ex ) {
			Logger::logEx( $ex, "Could not queue message to queue '$queue', msg->$msgText'", LOG_ERR, "PhpStomp" );
			return false;
		}

		return true;
	}
}
