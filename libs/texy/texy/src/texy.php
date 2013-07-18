<?php

/**
 * Texy! is human-readable text to HTML converter (http://texy.info)
 *
 * Copyright (c) 2004, 2012 David Grudl (http://davidgrudl.com)
 *
 * For the full copyright and license information, please view
 * the file license.txt that was distributed with this source code.
 */


/**
 * Check PHP configuration.
 */
if (version_compare(PHP_VERSION, '5.3.0') < 0) {
	throw new Exception('Texy requires PHP 5.3.0 or newer.');
}

if (extension_loaded('mbstring')) {
	if (mb_get_info('func_overload') & 2 && substr(mb_get_info('internal_encoding'), 0, 1) === 'U') { // U??
		mb_internal_encoding('pass');
		trigger_error("Texy: mb_internal_encoding changed to 'pass'", E_USER_WARNING);
	}
}

if (ini_get('zend.ze1_compatibility_mode') % 256 ||
	preg_match('#on$|true$|yes$#iA', ini_get('zend.ze1_compatibility_mode'))
) {
	throw new RuntimeException("Texy cannot run with zend.ze1_compatibility_mode enabled.");
}


// Texy! libraries
require_once __DIR__ . '/Texy/RegExp.Patterns.php';
require_once __DIR__ . '/Texy/TexyObject.php';
require_once __DIR__ . '/Texy/TexyHtml.php';
require_once __DIR__ . '/Texy/TexyModifier.php';
require_once __DIR__ . '/Texy/TexyModule.php';
require_once __DIR__ . '/Texy/TexyParser.php';
require_once __DIR__ . '/Texy/TexyConfigurator.php';
require_once __DIR__ . '/Texy/TexyHandlerInvocation.php';
require_once __DIR__ . '/Texy/TexyPcreException.php';
require_once __DIR__ . '/Texy/Texy.php';
require_once __DIR__ . '/Texy/modules/TexyParagraphModule.php';
require_once __DIR__ . '/Texy/modules/TexyBlockModule.php';
require_once __DIR__ . '/Texy/modules/TexyHeadingModule.php';
require_once __DIR__ . '/Texy/modules/TexyHorizLineModule.php';
require_once __DIR__ . '/Texy/modules/TexyHtmlModule.php';
require_once __DIR__ . '/Texy/modules/TexyFigureModule.php';
require_once __DIR__ . '/Texy/modules/TexyImageModule.php';
require_once __DIR__ . '/Texy/modules/TexyLinkModule.php';
require_once __DIR__ . '/Texy/modules/TexyListModule.php';
require_once __DIR__ . '/Texy/modules/TexyLongWordsModule.php';
require_once __DIR__ . '/Texy/modules/TexyPhraseModule.php';
require_once __DIR__ . '/Texy/modules/TexyBlockQuoteModule.php';
require_once __DIR__ . '/Texy/modules/TexyScriptModule.php';
require_once __DIR__ . '/Texy/modules/TexyEmoticonModule.php';
require_once __DIR__ . '/Texy/modules/TexyTableModule.php';
require_once __DIR__ . '/Texy/modules/TexyTypographyModule.php';
require_once __DIR__ . '/Texy/modules/TexyHtmlOutputModule.php';