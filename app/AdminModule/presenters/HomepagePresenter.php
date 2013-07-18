<?php

namespace App\Admin;


/**
 * Homepage
 */
class HomepagePresenter extends BasePresenter
{

	public function actionDefault()
	{
		$this->redirect('Articles:');
	}

}
