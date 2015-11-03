<?php
/**
 * IDProvider is a MediaWiki Extension that provides (unique) ID's in serveral ways:
 * * Through the API
 * * Through a PHP getter function
 * * Through wikitext string substitutions (@see http://mediawiki.org/wiki/Extension:Substitutor)
 *
 * @see http://mediawiki.org/wiki/Extension:IDProvider
 *
 * @file
 * @ingroup Extensions
 * @package MediaWiki
 *
 * @links https://github.com/gesinn-it/IDProvider/blob/master/README.md Documentation
 * @links https://github.com/gesinn-it/IDProvider Source code
 *
 * @author Simon Heimler, 2015
 * @license http://opensource.org/licenses/mit-license.php The MIT License (MIT)
 */


if (function_exists('wfLoadExtension')) {

	wfLoadExtension('IDProvider');

	// Keep i18n globals so mergeMessageFileList.php doesn't break
	$wgMessagesDirs['IDProvider'] = __DIR__ . '/i18n';
//	$wgExtensionMessagesFiles['IDProviderAlias'] = __DIR__ . '/IDProvider.alias.php';

	wfWarn(
		'Deprecated PHP entry point used for the IDProvider extension. Please use wfLoadExtension("IDProvider"); instead, ' .
		'see https://www.mediawiki.org/wiki/Extension_registration for more details.'
	);
	return;


} else {

	// @deprecated extension loading (!)


	//////////////////////////////////////////
	// VARIABLES                            //
	//////////////////////////////////////////

	$dir         = dirname( __FILE__ );
	$dirbasename = basename( $dir );


	//////////////////////////////////////////
	// CONFIG                               //
	//////////////////////////////////////////

	$wgSubstitutorMinRand          = 1000000000;
	$wgSubstitutorMaxRand          = 9999999999;
	$wgSubstitutorRandStringLength = 12;


	//////////////////////////////////////////
	// CREDITS                              //
	//////////////////////////////////////////

	$wgExtensionCredits['other'][] = array(
		'path'           => __FILE__,
		'name'           => 'IDProvider',
		'author'         => array('Simon Heimler'),
		'version'        => '0.2.0',
		'url'            => 'https://www.mediawiki.org/wiki/Extension:IDProvider',
		'descriptionmsg' => 'idprovider-desc',
		'license-name'   => 'MIT'
	);


	//////////////////////////////////////////
	// LOAD FILES                           //
	//////////////////////////////////////////

	// Load Classes
	$wgAutoloadClasses['IDProviderHooks'] = $dir . '/IDProvider.hooks.php';
	$wgAutoloadClasses['IDProviderFunctions'] = $dir . '/IDProvider.functions.php';
	$wgAutoloadClasses['IDProviderApi'] = $dir . '/api/IDProviderApi.php';

	// Register hooks
	$wgHooks['PageContentSaveComplete'][] = 'IDProviderHooks::onPageContentSaveComplete';

	// Register API
	$wgAPIListModules['idprovider'] = 'IDProviderApi';


}
