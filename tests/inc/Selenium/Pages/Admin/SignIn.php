<?php

namespace Tests\Selenium\Pages\Admin;

use Se34\PageObject,
	Se34\Element;


/**
 * Přihlašovací stránka.
 *
 * @property-read Element $username name=username, input, [type=text]
 * @property-read Element $password name=password, input, [type=password]
 * @property-read Element $submit name=send, input, [type=submit]
 *
 * @author Tomáš Sušánka
 */
class SignIn extends PageObject
{

	protected $presenterName = 'Admin:Sign';
	protected $presenterParameters = 'action = in';

	/**
	 * @return SignIn|Articles
	 */
	public function clickSubmit()
	{
		$this->submit->click();
		$this->session->waitForDocument();

		return $this->getNextPage();
	}

}
