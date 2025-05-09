<?php

use MediaWiki\Session\SessionManager;

/**
 * Base class for special pages that process email opt-in and unsubscribe requests.
 *
 * It operates in two stages: verification and action.
 * - The verification stage looks at all the data passed in the URI string; determines if it is
 *   complete and sufficient for the process; and then presents a 'are you sure' form to the user.
 *   It also stores all required parameters in session data.
 * - The action stage - provided the user was sure they wanted to opt in or unsubscribe -
 *   then performs the action.
 *
 * URI Parameters
 *  - The verification stage requires, at a minimum, the following two parameters:
 *  -- 'p' - The process, as listed in $wgFundraisingEmailUnsubscribeProcess to execute.
 *            Note that one process may include multiple methods, such as opting out via
 *            both CiviCRM and a bulk email provider.
 *  -- 'email' - The email address of the user, this may be mapped through
 *                 $wgFundraisingEmailUnsubscribeVarMap.
 *
 *  - The action stage requires:
 *  -- 'token'   - An edit token generated in the verification stage
 *  -- 'execute' - Must evaluate to 'True' for the action to be taken. Otherwise it will redirect
 *                 to the URL specified in $wgFundraisingEmailUnsubscribeCancelURI:
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

abstract class FundraiserSubscriptionPage extends SpecialPage {

	private const KEY_PROCESS = 'p';
	private const FILT_PROCESS = '/[a-zA-Z0-9]*/';

	private const KEY_EXECUTE = 'execute';
	private const FILT_EXECUTE = '/[a-zA-Z0-9]*/';

	private const KEY_VARIANT = 'v';
	private const FILT_VARIANT = '/[a-zA-Z0-9_-]*/';

	/** @var array[] */
	private $mObjects = [];

	/** @var string */
	private $mProcess = '';

	/** @var string */
	protected $mVariant = '';

	/** @var string */
	private $mEmail = '';

	/** @var int */
	private $mID = 0;

	/** @return string */
	abstract protected function getQueryTemplate();

	/** @return string */
	abstract protected function getSuccessTemplate();

	/** @return string */
	abstract protected function getErrorTemplate();

	/** @return string */
	protected function getTemplateDir() {
		return __DIR__ . '/templates';
	}

	/**
	 * Execute either the verification of a subscription request, or a subscription action.
	 *
	 * @param string $sub
	 */
	public function execute( $sub ) {
		$processes = $this->getConfig()->get( 'FundraisingEmailUnsubscribeProcesses' );

		// Initiate logging. Although we generate the ID every time, we will reset to a stashed ID
		// in loadSessionData() if it exists.
		Logger::setBucket( 'FundraisingEmailUnsubscribe' );
		$this->mID = rand( 1e12, 9e12 );
		Logger::setContext( $this->mID );

		// Prepare template environment
		$mwt = new MediaWikiTwig( $this->getTemplateDir(), $this->getContext() );

		// Walk through the steps of the process. If we have a 'p' parameter we're just starting,
		// If we have data in the session, and the 'execute' parameter, we're finishing
		$outContent = '';
		$this->mProcess = $this->getFilteredValue( self::KEY_PROCESS, self::FILT_PROCESS );
		$this->mVariant = $this->getFilteredValue( self::KEY_VARIANT, self::FILT_VARIANT );
		$execute = $this->getFilteredValue( self::KEY_EXECUTE, self::FILT_EXECUTE );
		$errorTemplate = $this->getErrorTemplate();

		if ( array_key_exists( $this->mProcess, $processes ) ) {
			// Stage 1: Asking if they really mean to do this. But we do have some setup to do first
			// phpcs:ignore MediaWiki.Usage.SuperGlobalsUsage.SuperGlobals
			Logger::log( "Starting process '$this->mProcess' with URI variables: " . json_encode( $_GET + $_POST ) );
			$template = $this->getQueryTemplate();

			$this->instantiateObjects();
			if ( $this->stashData() && $this->doVerify() ) {
				// Output page
				$outContent = $mwt->render( $template, $this->getTemplateParams() );
			} else {
				// yay; errors
				$outContent = $mwt->render( $errorTemplate, $this->getTemplateParams() );
				$this->clearData();
			}

		} elseif ( $this->loadSessionData() ) {
			Logger::log( 'Resuming session' );

			if ( $execute == true ) {
				if ( $this->executeSubscriptionRequest() ) {
					// Sadness, we lost a donation person
					Logger::log( 'Subscription action success' );
					$template = $this->getSuccessTemplate();
					$outContent = $mwt->render( $template, $this->getTemplateParams() );
					$this->clearData();
				} else {
					// Oh noes... errorz
					Logger::log( 'Subscription action failed' );
					$outContent = $mwt->render( $errorTemplate, $this->getTemplateParams() );
					$this->clearData();
				}
			} else {
				// Apparently they decided not to cancel, redirect somewhere else
				Logger::log( 'User decided to cancel action!' );
				$this->clearData();
				$this->getOutput()->redirect( $this->getConfig()->get( 'FundraisingEmailUnsubscribeCancelUri' ) );
				return;
			}
		} else {
			// Well, we had an unexpected error. That's nice...
			Logger::log( "Could not process '$this->mProcess' or execute pre-existing session." );
			$outContent = $mwt->render( $errorTemplate, $this->getTemplateParams() );
			$this->clearData();
		}

		// Now do whatever we have to do to output the content in $outContent
		// Hide unneeded interface elements
		$this->getOutput()->addModules( 'fundraiserUnsubscribe.skinOverride' );

		$this->setHeaders();
		$this->getOutput()->addHTML( $outContent );
	}

	/**
	 * @return array
	 */
	protected function getTemplateParams() {
		$languageCode = $this->getLanguage()->getCode();
		$config = $this->getConfig();

		// $wgDonationInterfacePolicyURL has $language and $country variables
		// to replace. We know language but not country.

		$copiedDonationInterfacePolicyURL = $config->has( 'DonationInterfacePolicyURL' )
			? $config->get( 'DonationInterfacePolicyURL' )
			// If DonationInterface isn't loaded; fall back to blank.
			: '';

		$policyUrl = str_replace(
			'$country',
			'',
			$copiedDonationInterfacePolicyURL
		);

		$policyUrl = str_replace(
			'$language',
			$languageCode,
			$policyUrl
		);
		$scriptPath = $config->get( 'ScriptPath' );
		return [
			'help_email' => $config->get( 'FundraisingEmailUnsubscribeHelpEmail' ),
			'uselang' => $languageCode,
			'email' => $this->mEmail,
			'token' => $this->mID,
			'action' => $this->getPageTitle()->getFullURL(),
			'policy_url' => $policyUrl,
			'template_path' => "$scriptPath/extensions/FundraisingEmailUnsubscribe/templates",
		];
	}

	/**
	 * Will attempt to instantiate instances of all classes required by the current process.
	 *
	 * @throws MWException
	 */
	private function instantiateObjects() {
		$processes = $this->getConfig()->get( 'FundraisingEmailUnsubscribeProcesses' );

		foreach ( $processes[$this->mProcess] as $className ) {
			if ( class_exists( $className, true ) ) {

				$instance = new $className();
				if ( !( $instance instanceof SubscriptionMethod ) ) {
					// Ehh? This class isn't what we want! ABORT ABORT!
					throw new MWException( "Class '$className' is not a derived class of SubscriptionMethod." );
				}

				$this->mObjects[] = [
					'instance' => $instance,
				];
			} else {
				// We seem to be missing a class. Log it and exit.
				throw new MWException( "Class '$className' does not exist." );
			}
		}
	}

	/**
	 * Verifies that all required parameters are present and valid in the URI string. In practice
	 * this function will call the validateRequest() function of any enabled method in the current
	 * process that implements ISubscriptionValidator. This is useful for when a method cannot
	 * reasonably provide a validation method, ie: silverpop.
	 *
	 * @return bool True if action can proceed.
	 */
	private function doVerify() {
		foreach ( $this->mObjects as &$classObjArray ) {
			$classObj = $classObjArray['instance'];
			$params = $classObjArray['params'];

			$className = get_class( $classObj );
			if ( $classObj instanceof ISubscriptionValidator ) {
				Logger::log( "Running $className verification" );
				if ( !$classObj->validateRequest( $params ) ) {
					$className = get_class( $classObj );
					$pstr = json_encode( $params );
					Logger::log( "$className failed validation of $pstr", LOG_ERR );
					return false;
				}
			}
		}

		return true;
	}

	/**
	 * Performs all registered subscription actions provided the edit token is valid. Even if a
	 * method fails, all other methods will be attempted. The error will of course be reported :)
	 *
	 * @return bool True if all methods successfully executed. False if any or all failed.
	 */
	private function executeSubscriptionRequest() {
		// Is the edit token, aka $this->mID, valid?
		$token = $this->getFilteredValue( 'token', '/[0-9]*/' );
		if ( $token != $this->mID ) {
			Logger::log( "Provided edit token '$token' does not match session token." );
			return false;
		}

		$retval = true;

		foreach ( $this->mObjects as $classObjArray ) {
			$classObj = $classObjArray['instance'];
			$params = $classObjArray['params'];
			$params += [ 'variant' => $this->mVariant ];

			$className = get_class( $classObj );
			try {
				$subscriptionResult = $classObj->update( $this->mID, $this->mProcess, $params );

				if ( $subscriptionResult == false ) {
					$pstr = json_encode( $params );
					Logger::log( "$className failed subscription request of $pstr", LOG_ALERT );
					$retval = false;
				} else {
					Logger::log( "$className processed subscription request successfully", LOG_INFO );
				}
			} catch ( Exception $ex ) {
				$pstr = json_encode( $params );
				Logger::logEx( $ex, "$className failed subscription request of $pstr" );
				$retval = false;
			}
		}

		return $retval;
	}

	/**
	 * Obtain all required parameters from the URI, filter and validate, stash to session, and
	 * save them attached to the correct object in $this->mObjects[?]['params'] for calling later.
	 *
	 * Note: This takes a bit of a shortcut and assumes that the filters are shared between
	 * getRequiredValidationParameters() and getRequiredParameters().
	 *
	 * Complex variable reduction takes place in reduceStandaside()
	 *
	 * @return bool Returns true if operation was a success. False if something was missing.
	 */
	private function stashData() {
		$varMap = $this->getConfig()->get( 'FundraisingEmailUnsubscribeVarMap' );
		$sessionKey = $this->getConfig()->get( 'FundraisingEmailUnsubscribeSessionKey' );

		// This variable will store, at the end, all the parameters that passed through the
		// variable map. This helps us process annoyingly derived parameters.
		$solvedParams = [];

		// This variable stores all the parameters that cannot be processed in the main loop. IE:
		// they rely on other parameters to be decoded first. It has a form of:
		// [
		// varmapped name,
		// original varmap entry,
		// filter string,
		// reference to 'params' array
		// ]
		$standasideParams = [];

		// Do all the simple variable extraction
		foreach ( $this->mObjects as &$classObjArray ) {
			$classObj = $classObjArray['instance'];
			$classObjArray['params'] = [];

			// Get what the class expects; and how to validate it
			$expectedParams = [];
			if ( $classObj instanceof ISubscriptionValidator ) {
				$expectedParams = $classObj->getRequiredValidationParameters();
			}
			$expectedParams = array_merge( $classObj->getRequiredParameters(), $expectedParams );

			// Now get the parameters from the URI; then filter
			$paramMap = $varMap[$this->mProcess];
			foreach ( $expectedParams as $paramName => $filtString ) {
				// Variable in the variable map?
				if ( array_key_exists( $paramName, $paramMap ) ) {
					$keyMapObject = $paramMap[$paramName];

					if ( is_array( $keyMapObject ) || ( strpos( $keyMapObject, '!' ) !== false ) ) {
						// Complex processing required, yay lambda expressions! (or external
						// references). Let's just store this for now and come back to it later.
						$standasideParams[] = [
							'paramName' => $paramName,
							'keyMapObject' => $keyMapObject,
							'filtString' => $filtString,
							'arrayRef' => &$classObjArray['params'],
						];

					} else {
						// Take the value normally; it's just mapped differently
						$keyValue = $this->getFilteredValue( $keyMapObject, $filtString );

						if ( $keyValue == '' ) {
							// That's unfortunate; the value doesn't work...
							Logger::log( "Parameter failed filtering: '$keyMapObject' -> '$paramName'" );
							return false;
						} else {
							Logger::log( "Resolved parameter '$paramName' to " . json_encode( $keyValue ) );
							$solvedParams[$paramName] = $keyValue;
							$classObjArray['params'][$paramName] = $keyValue;
						}
					}

				} else {
					$keyValue = $this->getFilteredValue( $paramName, $filtString );

					if ( $keyValue == '' ) {
						// That's unfortunate; the value doesn't work...
						Logger::log( "Parameter failed filtering: '$paramName'" );
						return false;
					} else {
						$classObjArray['params'][$paramName] = $keyValue;
					}
				}
			}
		}

		// Now we have to evaluate all the lambda expressions and work out the mess that is
		// derived parameters. 3, although arbitrary, does allow us a generous amount of breathing
		// room to solve strange dependencies.
		$iterCount = 3;
		while ( count( $standasideParams ) > 0 ) {
			foreach ( $standasideParams as $key => $standasideParam ) {
				try {
					if ( $this->reduceStandaside( $standasideParam, $solvedParams ) ) {
						unset( $standasideParams[$key] );
					}
				} catch ( MWException $ex ) {
					$keyName = $standasideParam['paramName'];
					Logger::logEx( $ex, "Param '$keyName' failed reduction.", LOG_INFO );
					return false;
				}
			}

			if ( --$iterCount == 0 ) {
				// well, we done fucked up here...
				Logger::log( "Could not resolve varmap dependencies for process '$this->mProcess'", LOG_ERR );
				return false;
			}
		}

		// Apparently we made it through alive :) Save to session and report all is good!
		SessionManager::getGlobalSession()->persist();

		if ( array_key_exists( 'email', $solvedParams ) ) {
			$this->mEmail = $solvedParams['email'];
		} else {
			// What? No email...
			Logger::log( 'Cancelling operation: Email address not translated.', LOG_ERR );
			return false;
		}

		$_SESSION[$sessionKey]['process'] = $this->mProcess;
		$_SESSION[$sessionKey]['variant'] = $this->mVariant;
		$_SESSION[$sessionKey]['email'] = $this->mEmail;
		$_SESSION[$sessionKey]['id'] = $this->mID;

		foreach ( $this->mObjects as &$classObjArray ) {
			$classObj = $classObjArray['instance'];
			$params = $classObjArray['params'];

			$_SESSION[$sessionKey]['class-data'][get_class( $classObj )] = $params;
		}

		return true;
	}

	/**
	 * Called by stashData() when we have complex parameters that need to be dealt with. It's
	 * broken out here to make it a <em>little</em> bit more readable. It can handle both derived
	 * variables and lambda expression calls.
	 *
	 * Lambda expressions are interesting. They can either be true PHP lambda's (ie: derived from
	 * Closure) or class static functions. Either way they must accept only a single argument which
	 * is an array of key->value pairs as dictated by the variable map.
	 *
	 * @param array $standasideParam Information on the parameter we're solving for.
	 * @param array &$solvedParams Key->Value of all parameters already solved for.
	 *
	 * @return bool If the parameter was successfully solved.
	 */
	private function reduceStandaside( $standasideParam, &$solvedParams ) {
		$solved       = false;
		$value        = '';
		// What we're solving for
		$paramName = $standasideParam['paramName'];
		// What info we have on it
		$keyMapObject = $standasideParam['keyMapObject'];
		// How we have to filter it
		$filtString = $standasideParam['filtString'];
		// Reference to where do we store it
		$arrayRef = &$standasideParam['arrayRef'];

		// Now do actual work; we have two options; a lambda expression or a remap
		if ( is_array( $keyMapObject ) ) {
			// Lambda expression
			$function = $keyMapObject[0];
			$reqParam = array_slice( $keyMapObject, 1 );
			$reqParamValues = [];
			$evaluate = true;

			// Can we evaluate the expression at this time?
			foreach ( $reqParam as $reqParamName ) {
				if ( strpos( $reqParamName, '!' ) !== false ) {
					// Is it in the solved list?
					$key = explode( '!', $reqParamName, 2 );
					$key = $key[1];
					if ( array_key_exists( $key, $solvedParams ) ) {
						$reqParamValues[$key] = $solvedParams[$key];
					} else {
						$evaluate = false;
						break;
					}
				} else {
					// It comes from the URI; grab it. We do not filter this because we don't know
					// what a valid filter would be. Therefore the lamba just has to be smart enough
					// to know how to deal with it.
					$reqParamValues[$reqParamName] = $this->getFilteredValue(
						$reqParamName,
						'/.*/',
						''
					);
				}
			}

			// Evaluate it if possible
			if ( $evaluate ) {
				if ( is_a( $function, Closure::class ) ) {
					$raw = $function( $reqParamValues );
				} else {
					[ $class, $funcName ] = explode( '::', $function );
					$raw = $class::$funcName( $reqParamValues );
				}

				$value = $this->filterValue( $raw, $filtString );
				$solved = true;
			}

		} else {
			// We have a simple remap using a derived variable.
			$var = explode( '!', $keyMapObject, 2 );
			$var = $var[1];
			if ( array_key_exists( $var, $solvedParams ) ) {
				// Yay! It's solved (unless it fails 'validation)
				$value = $this->filterValue( $solvedParams[$var], $filtString );
				$solved = true;
			}
		}

		// Clean up
		if ( $solved === true ) {
			Logger::log( "Resolved parameter '$paramName' to " . json_encode( $value ) );
			$solvedParams[$paramName] = $value;
			$arrayRef[$paramName] = $value;
		}

		return $solved;
	}

	/**
	 * Reloads all required session data
	 *
	 * @return bool True if session could be successfully restored.
	 */
	private function loadSessionData() {
		$skey = $this->getConfig()->get( 'FundraisingEmailUnsubscribeSessionKey' );

		// For ease of code; we're going to assume that if the session key exists, everything else
		// will as well. This might come back to bite me in the ass later...
		if ( ( session_id() != null ) && array_key_exists( $skey, $_SESSION ) ) {
			$this->mProcess = $_SESSION[$skey]['process'];
			$this->mEmail = $_SESSION[$skey]['email'];
			$this->mVariant = $_SESSION[$skey]['variant'];
			$this->mID = $_SESSION[$skey]['id'];

			Logger::setContext( $this->mID );

			$this->instantiateObjects();
			foreach ( $this->mObjects as &$classObjArray ) {
				$classObj = $classObjArray['instance'];
				$classObjArray['params'] = $_SESSION[$skey]['class-data'][get_class( $classObj )];
			}

			return true;
		} else {
			return false;
		}
	}

	/**
	 * Clears subscription request data from the session
	 */
	private function clearData() {
		$sessionKey = $this->getConfig()->get( 'FundraisingEmailUnsubscribeSessionKey' );
		unset( $_SESSION[$sessionKey] );
	}

	/**
	 * Gets a value from the URI string by $key, filter it by $filter, and return the result.
	 *
	 * @param string $key The key to obtain from the URI string
	 * @param string $filter The PCRE filter to run on the value
	 * @param string $expected The expected value if the filter fails or it the result doesn't exist
	 *
	 * @return string The filtered result.
	 */
	private function getFilteredValue( $key, $filter, $expected = '' ) {
		return $this->filterValue(
			// $this->getRequest()->getVal( $key, $expected ), <--switch these back out when the mangled links stop
			$this->getRequestValCleanKeys( $key, $expected ),
			$filter,
			$expected
		);
	}

	/**
	 * Containment for a temporary fix, for the long tail on mangled unsub links
	 * in emails that went out between 11/2 and 11/3, 2012.
	 * Once we stop seeing 'amp;' in the logs, we can whack this and go back to
	 * just using getVal in getFilteredValue().
	 *
	 * @param string $key
	 * @param string $expected
	 *
	 * @return string
	 */
	private function getRequestValCleanKeys( $key, $expected ) {
		static $vals = null;
		if ( $vals === null ) {
			$vals = $this->getRequest()->getValues();
			$mangled = false;
			foreach ( $vals as $vk => $vv ) {
				if ( strpos( $vk, 'amp;' ) !== false ) {
					$mangled = true;
					// some have multiples.
					$rekey = str_replace( 'amp;', '', $vk );
					$vals[$rekey] = $vv;
					unset( $vals[$vk] );
				}
			}
			if ( $mangled ) {
				Logger::log( "Found another mangled URL.", LOG_INFO );
			}
		}

		if ( !array_key_exists( $key, $vals ) || $vals[$key] === null ) {
			return $expected;
		}

		return $vals[$key];
	}

	/**
	 * When all you have is a raw value; how does one sanitize it!? Answer, this function!
	 *
	 * @param string $rawValue The raw value to poke and prod at
	 * @param string $filter The regex to use to validate the $rawValue
	 * @param null $expected What to return if the validation fails. Default is null which will
	 *                          throw an exception on unhappyness.
	 *
	 * @return null The sanitized value :)
	 * @throws MWException If $expected was null and the validation failed.
	 */
	private function filterValue( $rawValue, $filter, $expected = null ) {
		$matches = [];
		preg_match( $filter, $rawValue, $matches );
		if ( ( count( $matches ) > 0 ) && ( $matches[0] !== '' ) ) {
			return $matches[0];
		} elseif ( $expected !== null ) {
			return $expected;
		} else {
			throw new MWException( "Parameter failed validation raw: ($rawValue), filter: ($filter)" );
		}
	}
}
