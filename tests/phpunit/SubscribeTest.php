<?php

if ( file_exists( __DIR__ . '/../../vendor/autoload.php' ) ) {
	include_once __DIR__ . '/../../vendor/autoload.php';
}

/**
 * @group FundraisingEmailUnsubscribe
 * @covers FundraiserSubscribe
 */
class SubscribeTest extends MediaWikiIntegrationTestCase {
	/**
	 * @var FundraiserSubscribe
	 */
	protected $processor;

	public function setUp(): void {
		parent::setUp();
		$this->overrideConfigValues( [
			'FundraisingEmailUnsubscribeQueueClass' => \PHPQueue\Backend\PDO::class,
			'FundraisingEmailUnsubscribeQueueParameters' => [
				'opt-in' => [
					'connection_string' => 'sqlite::memory:',
					// this backend needs a valid table name
					'queue' => 'opt_in',
				],
			],
		] );
		$this->processor = new FundraiserSubscribe();
	}

	public function testSendMessage() {
		$id = mt_rand();
		$this->processor->update(
			$id, 'optin', [
				'email' => 'donor@example.com',
				'variant' => '',
			]
		);
		$queue = FundraiserEmailQueue::get( 'opt-in' );
		$message = $queue->pop();
		$this->assertNotNull( $message );
		$this->assertEquals( [
			'email' => 'donor@example.com',
			'process' => 'optin',
			'variant' => ''
		], $message );
	}

	public function testSendMessageVariant() {
		$id = mt_rand();
		$this->processor->update(
			$id, 'optin', [
				'email' => 'donor@example.com',
				'variant' => 'bloop_de_woop',
			]
		);
		$queue = FundraiserEmailQueue::get( 'opt-in' );
		$message = $queue->pop();
		$this->assertNotNull( $message );
		$this->assertEquals( [
			'email' => 'donor@example.com',
			'process' => 'optin',
			'variant' => 'bloop_de_woop'
		], $message );
	}
}
