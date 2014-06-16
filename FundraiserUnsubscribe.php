<?php
/**
 * Extension:FundraiserUnsubscribe. This extension allows a user to unsubscribe from a fundraising
 * mailing list.
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

// Alert the user that this is not a valid entry point to MediaWiki if they try to access the
// special pages file directly.
if ( !defined( 'MEDIAWIKI' ) ) {
	echo <<<EOT
To install the FundraiserUnsubscribe extension, put the following line in LocalSettings.php:
require_once "$IP/extensions/FundraisingEmailUnsubscribe/FundraiserUnsubscribe.php";
EOT;
	exit( 1 );
}

$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'FundraiserUnsubscribe',
	'author' => array( 'Matt Walker' ),
	'url' => 'https://www.mediawiki.org/wiki/Extension:FundraiserUnsubscribe',
	'descriptionmsg' => 'fundraiserunsubscribe-desc',
	'version' => '2.0.0',
);

// === Core Includes, Pages, and Autoload Registration ===
$dir = __DIR__ . '/';

$wgMessagesDirs['FundraiserUnsubscribe'] = __DIR__ . '/i18n';
$wgExtensionMessagesFiles['FundraiserUnsubscribe']      = $dir . 'FundraiserUnsubscribe.i18n.php';

$wgAutoloadClasses['SpecialFundraiserUnsubscribe']      = $dir . 'SpecialFundraiserUnsubscribe.php';
$wgSpecialPages['FundraiserUnsubscribe'] = 'SpecialFundraiserUnsubscribe';

$wgAutoloadClasses['Logger']                            = $dir . 'includes/Logger.php';
$wgAutoloadClasses['FundraiserUnsubscribeStompAdapter'] = $dir . 'includes/StompAdapter.php';
$wgAutoloadClasses['XmlTransactionProcessor']           = $dir . 'includes/XmlTransactionProcessor.php';
$wgAutoloadClasses['MediaWikiTwig']                     = $dir . 'includes/MediaWikiTwig.php';

// === Configuration Parameters ===
/** @var $wgFundraiserUnsubscribeSessionKey Root key to use in the $_SESSION array. */
$wgFundraiserUnsubscribeSessionKey = 'fr-unsub';

/** @var $wgFundraiserUnsubscribeCancelUri User is redirected here when they click 'cancel'. */
$wgFundraiserUnsubscribeCancelUri = 'https://www.wikimediafoundation.org/';

/** @var $wgFundraiserUnsubscribeHelpEmail All messages that require an email address, ie for
 * help/questions will include this email address. */
$wgFundraiserUnsubscribeHelpEmail = 'donations@wikimedia.org';

/** @var $wgFundraiserUnsubscribeHashSecretKey Random secret HMAC key used for validating email addresses */
$wgFundraiserUnsubscribeHashSecretKey = '';

/**
 * Silverpop integration variables.
 *  - The username and password should have API access from the server IP.
 *  - Timeout is expressed in seconds and is for each API call. It is not cumulative.
 *  - URL is the API endpoint. See the Silverpop API Endpoints Appendix.
 *{
 */
$wgFundraiserUnsubscribeSilverpopUsername = null;
$wgFundraiserUnsubscribeSilverpopPassword = null;
$wgFundraiserUnsubscribeSilverpopTimeout = 5;
$wgFundraiserUnsubscribeSilverpopURL = null;
/**}*/

/** @var $wgFundraiserUnsubscribeLogFacility What syslog facility to use when logging */
$wgFundraiserUnsubscribeLogFacility = LOG_USER;

/** @var $wgFundraiserUnsubscribeLogXmlTransactions When TRUE the XMLTransaction class will log outbound data */
$wgFundraiserUnsubscribeLogXmlTransactions = false;


// === Method Registration ===
$mdir = $dir . 'methods';
$wgAutoloadClasses['UnsubscribeMethod']                 = $mdir . '/UnsubscribeMethod.php';
$wgAutoloadClasses['FundraiserUnsubscribeThankYou']     = $mdir . '/FundraiserUnsubscribeThankYou.php';
$wgAutoloadClasses['FundraiserUnsubscribeSilverpop']    = $mdir . '/FundraiserUnsubscribeSilverpop.php';

/**
 * The $wgFundraiserUnsubscribeProcesses defines all valid unsubscribe 'p' processes and the classes
 * that handle those processes. Each process must have a corresponding entry in the
 * $wgFundraiserUnsubscribeVarMap array.
 */
$wgFundraiserUnsubscribeProcesses = array(
	'thankyou' => array(
		'FundraiserUnsubscribeThankYou',
	),

	'silverpop' => array(
		'FundraiserUnsubscribeThankYou',
		'FundraiserUnsubscribeSilverpop',
	),
);

/**
 * $wgFundraiserUnsubscribeVarMap is a large, multidimesional array paired with the process array.
 * The primary key is the process name passed in the 'p' parameter.
 *
 * A translation map can be as simple as a key/value pair, where the key is the class expected
 * parameter name and the value is what is actually passed in the URI string. It can also be a
 * key/array pair where once again the key is the expected parameter name; the array will be a
 * lambda expression followed by any values required from the URI string. If you want to be really
 * annoying, you can prepend a '!' to any variable in the list and it will be evaluated from a
 * translated variable.
 *
 * If the class requires a variable that is not specified in the translation map, it is expected
 * to be as-is in the URI string.
 *
 * This map does not fully describe all parameters to the special page -- nor should it. These are
 * only specific to initial processing.
 */
$wgFundraiserUnsubscribeVarMap = array(
	'thankyou' => array(
		'email' => array( 'FundraiserUnsubscribeThankYou::decodeEmail', 'e' ),
		'contribution-id' => 'c',
		'hash' => 'h',
	),

	'silverpop' => array(
		'email' => array( 'FundraiserUnsubscribeSilverpop::decodeEmail', 'e' ),
		'contribution-id' => 'c',
		'hash' => 'h',

		'mailing-id' => 'm',
		'recipient-id' => 'r',
		'job-id' => 'j',
		'list-id' => 'l',
	),
);

// === RESOURCE LOADER ===
$wgResourceModules['fundraiserUnsubscribe.skinOverride'] = array(
	'styles' => 'skinOverride.css',
	'position' => 'top',
	'localBasePath' => $dir . 'modules',
	'remoteExtPath' => 'FundraisingEmailUnsubscribe/modules',
);

// === LIBRARY CONFIGURATIONS ===
// --- Twig ---
$wgTwigPath = '/usr/lib/twig/';     // Path to the Twig library
$wgTwigCachePath = '/tmp/twig';     // Where Twig should store it's compiled templates
$wgTwigCacheExpiry = 5 * 60;        // Time, in seconds, for Twig to cache templates

$wgTwigTemplatePath = $dir . 'templates/';

$wgAutoloadClasses['MediaWikiTwigLoader'] = $dir . 'includes/MediaWikiTwigLoader.php';
