<?php

namespace App;

use Nette,
	Texy,
	TexyHeadingModule,
	TexyConfigurator;


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
	 * Processing by Texy!
	 *
	 * @param string
	 * @return string
	 */
	public function texy($value)
	{
		$texy = $this->createTexy();
		return $texy->process($value);
	}

	/**
	 * Creating and setting up texy
	 * @return Texy
	 */
	protected function createTexy()
	{
		$texy = new Texy();
		TexyConfigurator::safeMode($texy);
		$texy->headingModule->balancing = TexyHeadingModule::FIXED;
		$texy->allowedTags = $texy::NONE;
		$texy->setOutputMode($texy::HTML5);
		$texy->allowed['script'] = FALSE;
		$texy->allowed['html/tag'] = FALSE;
		$texy->allowed['html/comment'] = FALSE;

		return $texy;
	}

}
