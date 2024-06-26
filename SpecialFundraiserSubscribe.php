<?php

class SpecialFundraiserSubscribe extends FundraiserSubscriptionPage {

	public function __construct() {
		parent::__construct( 'FundraiserSubscribe' );
	}

	/** @return string */
	protected function getQueryTemplate() {
		$basename = 'optin';
		$variant = $this->mVariant;
		if ( $variant !== '' ) {
			// Prepend an underscore
			$variant = "_$variant";
		}
		$templateName = "$basename$variant.html";
		$fullPath = $this->getTemplateDir() . DIRECTORY_SEPARATOR . $templateName;
		if ( is_readable( $fullPath ) ) {
			return $templateName;
		}
		return 'optin.html';
	}

	/** @return string */
	protected function getSuccessTemplate() {
		return 'optinSuccess.html';
	}

	/** @return string */
	protected function getErrorTemplate() {
		return 'optinError.html';
	}
}
