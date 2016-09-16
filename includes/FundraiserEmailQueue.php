<?php

/**
 * Helper to fetch and stash a PHPQueue backend
 * Basically just holds a static reference so tests can look at the same
 * backend instance as the class being tested
 */
class FundraiserEmailQueue {
	static $instance;

	/**
	 * @return PHPQueue\Interfaces\FifoQueueStore
	 */
	public static function get() {
		global $wgFundraisingEmailUnsubscribeQueueClass,
			   $wgFundraisingEmailUnsubscribeQueueParameters;

		if ( !self::$instance ) {
			if ( empty( $wgFundraisingEmailUnsubscribeQueueParameters['queue'] ) ) {
				$wgFundraisingEmailUnsubscribeQueueParameters['queue'] = 'unsubscribe';
			}
			self::$instance = new $wgFundraisingEmailUnsubscribeQueueClass(
				$wgFundraisingEmailUnsubscribeQueueParameters
			);
		}

		return self::$instance;
	}
}
