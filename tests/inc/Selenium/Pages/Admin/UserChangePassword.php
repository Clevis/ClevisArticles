<?php

namespace Tests\Selenium\Pages\Admin;

use Se34\PageObject,
	Se34\Element;


/**
 * Stránka pro změnu hesla.
 *
 * @property-read Element $oldPass name=oldPass, input, [type=password]
 * @property-read Element $newPass name=newPass, input, [type=password]
 * @property-read Element $newPassRetry name=newPassRetry, input, [type=password]
 * @property-read Element $saveButton name=publish, input, [type=submit]
 *
 * @author Tomáš Sušánka
 */
class UserChangePassword extends PageObject
{

	protected $presenterName = 'Admin:User';
	protected $presenterParameters = 'action = changePassword';

	/**
	 * @return UserChangePassword|Articles
	 */
	public function clickSaveButton()
	{
		$this->saveButton->click();
		$this->session->waitForDocument();

		return $this->getNextPage();
	}

}
