<?php

namespace App;

use Nette;
use Texy;
use TexyHeadingModule;


class HelperLoader extends Nette\Object
{

	/**
	 * Callback for $template
	 *
	 * @param string
	 */
	public function loader($helperName)
	{
		if (method_exists($this, $helperName))
		{
			return callback($this, $helperName);
		}

		return NULL;
	}

	/**
	 * Zpracování přes Texy!
	 *
	 * @param string
	 * @return string
	 */
	public function texy($value)
	{
		$texy = new Texy();
		$texy->headingModule->balancing = TexyHeadingModule::FIXED;
		return $texy->process($value);
	}

}
