<?php

namespace Tests\Selenium\Pages\Front;

use Se34\PageObject;
use Se34\Element;


/**
 * Stránka se články.
 *
 *
 * @property-read Element $title xpath="//h2"
 * @property-read Element $italic xpath="//em"
 *
 * @author Tomáš Sušánka
 */
class Articles extends PageObject
{
	protected $presenterName = 'Front:Articles';
	protected $presenterParameters = 'action = view';

}
