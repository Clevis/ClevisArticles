<?php

namespace App\Admin;

use App;

/**
 * Admin base presenter
 *
 */
abstract class BasePresenter extends App\BasePresenter
{

	/** @var User|NULL aktuálně přihlášený uživatel */
	protected $userEntity;

	/**
	 * Reads User and stores it in userEntity
	 */
	public function startup()
	{
		parent::startup();

		if ($this->user->isLoggedIn())
		{
			$this->userEntity = $this->orm->users->getById($this->user->id);
		}
	}

	public function beforeRender()
	{
		parent::beforeRender();

		$this->template->signed = $this->user->isLoggedIn();

		if ($this->name !== 'Admin:Sign')
		{
			if (!$this->user->isLoggedIn())
			{
				$this->redirect('Sign:in', array('backlink' => $this->storeRequest()));
			}
		}
	}

}
