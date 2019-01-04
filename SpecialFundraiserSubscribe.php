<?php

class SpecialFundraiserSubscribe extends FundraiserSubscriptionPage {
	public function __construct() {
		parent::__construct( 'FundraiserSubscribe' );
	}

	protected function getQueryTemplate() {
		return 'optin.html';
	}

	protected function getSuccessTemplate() {
		return 'optinSuccess.html';
	}

	protected function getErrorTemplate() {
		return 'optinError.html';
	}
}
