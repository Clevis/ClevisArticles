<?php

namespace App\Front;


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
