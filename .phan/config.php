<?php

$cfg = require __DIR__ . '/../vendor/mediawiki/mediawiki-phan-config/src/config.php';

$cfg['directory_list'] = array_merge(
	$cfg['directory_list'],
	[
		'vendor/coderkungfu/php-queue/',
		'vendor/twig/twig/',
	]
);

$cfg['exclude_analysis_directory_list'] = array_merge(
	$cfg['exclude_analysis_directory_list'],
	[
		'vendor/coderkungfu/php-queue/',
		'vendor/twig/twig/',
	]
);

return $cfg;
