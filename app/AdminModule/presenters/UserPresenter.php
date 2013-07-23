<?php

namespace App\Admin;

use Nette;
use Nette\Application\UI\Form;


/**
 * User profile pages
 *
 */
final class UserPresenter extends BasePresenter
{

	/**
	 * Default action, there can be some more user editting later on.
	 *
	 */
	public function actionDefault()
	{
		$this->redirect('password');
	}

	/**
	 * Creates a component to change user's password.
	 *
	 */
	public function createComponentChangePasswordForm()
	{
		$form = new Form();

		$form->addPassword('oldPass', 'Původní heslo')
			->addRule(Form::FILLED, 'Jaké bylo vaše původní heslo?');

		$form->addPassword('newPass', 'Nové heslo')
			->addRule(Form::FILLED, 'Zvolte si prosím nové heslo.');

		$form->addPassword('newPassRetry', 'Nové heslo pro kontrolu')
			->addRule(Form::FILLED, 'Dvakrát měř, jednou řež. Zadejte nové heslo pro jistotu ještě jednou.')
			->addRule(Form::EQUAL, 'Heslo pro kontrolu se neshoduje s nově zvoleným heslem. Zkuste jej prosím zadat znovu.', $form['newPass']);

		$form->addSubmit('publish', 'Změnit heslo');
		$form->onSuccess[] = callback($this, 'processChangePasswordForm');

		return $form;
	}

	/**
	 * Processes the password form.
	 *
	 **/
	public function processChangePasswordForm(Form $form)
	{
		$values = $form->values;

		if (isset($values->oldPass) && !$this->context->passwordHashCalculator->verify($values->oldPass, $this->userEntity->password, $this->userEntity->username))
		{
			$form->addError('Staré heslo nesedí. Zkuste to ještě jednou. Pokud v hesle byla i velká písmena a čísla, zkontrolujte si, jestli nemáte zapnutý Caps Lock nebo vypnutý Num Lock.');
			return;
		}

		$this->userEntity->password = $this->context->passwordHashCalculator->hash($values->newPass);
		$this->orm->users->flush();

		$this->flashMessage('Heslo bylo úspěšně změněno');
		$this->redirect('Homepage:');
	}

}