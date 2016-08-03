<?php
/**
 * Extension:FundraisingEmailUnsubscribe. This extension allows a user to unsubscribe from a fundraising
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

if ( function_exists( 'wfLoadExtension' ) ) {
	wfLoadExtension( 'FundraisingEmailUnsubscribe' );
	// Keep i18n globals so mergeMessageFileList.php doesn't break
	// Load the interface messages that are shared across multiple gateways
	$wgMessagesDirs['FundraisingEmailUnsubscribe'][] = __DIR__ . '/i18n';
	$wgExtensionMessagesFiles['FundraisingEmailUnsubscribe'] = __DIR__ . '/FundraisingEmailUnsubscribe.i18n.php';
	return;
} else {
	die( 'This version of the FundraisingEmailUnsubscribe extension requires MediaWiki 1.27+' );
}
