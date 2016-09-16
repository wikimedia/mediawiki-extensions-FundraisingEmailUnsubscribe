<?php

/**
 * @group FundraisingEmailUnsubscribe
 */
class UnsubscribeThankYouTest extends MediaWikiTestCase {
	/**
	 * @var FundraiserUnsubscribeThankYou
	 */
	protected $unsubscriber;

	public function setUp() {
		parent::setUp();
		$this->setMwGlobals( array(
			'wgFundraisingEmailUnsubscribeQueueClass' => '\PHPQueue\Backend\PDO',
			'wgFundraisingEmailUnsubscribeQueueParameters' => array(
				'connection_string' => 'sqlite::memory:',
			),
			'wgFundraisingEmailUnsubscribeHashSecretKey' => 'Red/Fl4nn3l/#',
		) );
		$this->unsubscriber = new FundraiserUnsubscribeThankYou();
	}

	public function testValidateBadHash() {
		$result = $this->unsubscriber->validateRequest( array(
			'email' => 'pestered@example.com',
			'contribution-id' => '98765432',
			'hash' => 'a76f8eg86b87eg109c0d983d6a0e9a6d827e79c7',
		) );
		$this->assertFalse( $result, 'Bogus hash considered valid' );
	}

	public function testValidateGoodHash() {
		$result = $this->unsubscriber->validateRequest( array(
			'email' => 'pestered@example.com',
			'contribution-id' => '98765432',
			'hash' => '87b7b93fffbe72b61261e59941e3b6628b0e5689',
		) );
		$this->assertTrue( $result, 'Good hash considered invalid' );
	}

	public function testSendMessage() {
		$id = mt_rand();
		$this->unsubscriber->unsubscribe(
			$id, 'unsubscribe', array(
				'email' => 'donor@example.com',
				'contribution-id' => '123456'
			)
		);
		$queue = FundraiserEmailQueue::get();
		$message = $queue->pop();
		$this->assertNotNull( $message );
		$this->assertEquals( array(
			'email' => 'donor@example.com',
			'contribution-id' => '123456',
			'process' => 'unsubscribe',
		), $message );
	}
}
