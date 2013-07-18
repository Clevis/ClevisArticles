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

		if (!$this->user->isLoggedIn())
		{
            $this->redirect(':Sign:in', array('backlink' => $this->storeRequest()));
		}
	}

}
