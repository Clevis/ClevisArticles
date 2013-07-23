<?php

namespace Tests\Selenium;

use \Tests\Selenium\Pages;

/**
 * Test profilu uživatele.
 *
 * @author Tomas Susanka
 */
class UserProfile_Test extends SeleniumTestCase
{

	/**
	 * Testuje změnu hesla
	 *
	 * @author Tomas Susanka
	 */
	public function testChangePassword()
	{
		$result = $this->auth->login(
			$this->context->parameters['selenium']['testUser']['username'],
			$this->context->parameters['selenium']['testUser']['password']
		);
		$this->assertTrue($result);

		$articles = new Pages\Admin\Articles($this->session);

		$changePasswordPage = $articles->clickPasswordChange();

		$changePasswordPage->fill(array(
			'oldPass' => 'x',
			'newPass' => 'ahoj',
			'newPassRetry' => 'ahoj',
		));
		$changePasswordPage->clickSaveButton();

		$this->assertFlashMessage('Staré heslo nesedí.');

		$changePasswordPage->fill(array(
			'oldPass' => 'test',
			'newPass' => 'ahoj',
			'newPassRetry' => 'ahoj',
		));
		$changePasswordPage->clickSaveButton();

		$this->assertFlashMessage('Heslo bylo úspěšně změněno');

		$articles->clickLogout();

		$result = $this->auth->login(
			$this->context->parameters['selenium']['testUser']['username'],
			'ahoj'
		);
		$this->assertTrue($result);
	}
}
