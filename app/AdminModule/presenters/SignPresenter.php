<?php

namespace App\Admin;

use Nette;


/**
 * Sign in/out presenters.
 */
class SignPresenter extends BasePresenter
{


	/**
	 * Sign-in form factory.
	 *
	 * @return Nette\Application\UI\Form
	 */
	protected function createComponentSignInForm()
	{
		$form = new Nette\Application\UI\Form;

		$form->addText('username', 'Uživatelské jméno')
			->setRequired('Prosím zadejte vaše uživatelské jméno.')
			->setAttribute('placeholder', 'Uživatelské jméno');

		$form->addPassword('password', 'Heslo')
			->setRequired('Prosím zadejte vaše heslo.')
			->setAttribute('placeholder', 'Heslo');

		$form->addCheckbox('remember', 'Zapamatovat si přihlášení');

		$form->addProtection();

		$form->addSubmit('send', 'Přihlásit se');

		$form->onSuccess[] = $this->signInFormSucceeded;

		return $form;
	}


	public function signInFormSucceeded($form)
	{
		$values = $form->getValues();

		if ($values->remember)
		{
			$this->getUser()->setExpiration('14 days', FALSE);
		}
		else
		{
			$this->getUser()->setExpiration('20 minutes', TRUE);
		}

		try
		{
			$this->getUser()->login($values->username, $values->password);
			// $this->flashMessage('You have been signed in.');
			$this->redirect('Homepage:');
		}
		catch (Nette\Security\AuthenticationException $e)
		{
			$form->addError($e->getMessage());
		}
	}

	/**
	 * Sign-in form factory.
	 *
	 * @return Nette\Application\UI\Form
	 */
	protected function createComponentLostPasswordForm()
	{
		$form = new Nette\Application\UI\Form;
		$form->addText('email', 'Registrovaný e-mail')
			->setType('email')
			->addRule(Nette\Application\UI\Form::EMAIL)
			->setRequired('Prosím zadejte váš registrovaný e-mail.')
			->setAttribute('placeholder', 'Registrovaný e-mail');

		$form->addProtection();

		$form->addSubmit('send', 'Obnovit heslo');

		$form->onSuccess[] = $this->lostPasswordFormSucceeded;

		return $form;
	}

	public function lostPasswordFormSucceeded($form)
	{
		$values = $form->getValues();

		// @TODO
	}


	public function actionOut()
	{
		$this->getUser()->logout();
		$this->flashMessage('Byl jste odhlášen z aplikace.');
		$this->redirect('in');
	}

}
