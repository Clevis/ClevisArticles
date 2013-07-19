<?php

namespace App\Admin;

use App;

/**
 * Admin base presenter
 *
 */
abstract class BasePresenter extends App\BasePresenter
{

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
