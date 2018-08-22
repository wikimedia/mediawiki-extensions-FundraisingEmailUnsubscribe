<?php

class SpecialFundraiserSubscribe extends FundraiserSubscriptionPage {
	public function __construct() {
		SpecialPage::__construct( 'FundraiserSubscribe' );
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
