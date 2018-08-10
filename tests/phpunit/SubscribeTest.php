<?php

/**
 * @group FundraisingEmailUnsubscribe
 */
class SubscribeTest extends MediaWikiTestCase {
	/**
	 * @var FundraiserSubscribe
	 */
	protected $processor;

	public function setUp() {
		parent::setUp();
		$this->setMwGlobals( array(
			'wgFundraisingEmailUnsubscribeQueueClass' => '\PHPQueue\Backend\PDO',
			'wgFundraisingEmailUnsubscribeQueueParameters' => array(
				'opt_in' => array(
					'connection_string' => 'sqlite::memory:',
				),
			),
		) );
		$this->processor = new FundraiserSubscribe();
	}

	public function testSendMessage() {
		$id = mt_rand();
		$this->processor->update(
			$id, 'optin', array(
				'email' => 'donor@example.com',
			)
		);
		$queue = FundraiserEmailQueue::get( 'opt_in' );
		$message = $queue->pop();
		$this->assertNotNull( $message );
		$this->assertEquals( array(
			'email' => 'donor@example.com',
			'process' => 'optin'
		), $message );
	}
}
