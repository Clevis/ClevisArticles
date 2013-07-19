<?php

/**
 * Texy! is human-readable text to HTML converter (http://texy.info)
 *
 * Copyright (c) 2004 David Grudl (http://davidgrudl.com)
 *
 * For the full copyright and license information, please view
 * the file license.txt that was distributed with this source code.
 */


/**
 * Checking preg_last_error()
 */
class TexyPcreException extends Exception
{

	public function __construct($message = '%msg.')
	{
		static $messages = array(
			PREG_INTERNAL_ERROR => 'Internal error',
			PREG_BACKTRACK_LIMIT_ERROR => 'Backtrack limit was exhausted',
			PREG_RECURSION_LIMIT_ERROR => 'Recursion limit was exhausted',
			PREG_BAD_UTF8_ERROR => 'Malformed UTF-8 data',
			5 => 'Offset didn\'t correspond to the begin of a valid UTF-8 code point', // PREG_BAD_UTF8_OFFSET_ERROR
		);
		$code = preg_last_error();
		parent::__construct(str_replace('%msg', isset($messages[$code]) ? $messages[$code] : 'Unknown error', $message), $code);
	}

}
