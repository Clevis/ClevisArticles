<?php

namespace App\Front;


/**
 * Articles presenter
 */
final class ArticlesPresenter extends BasePresenter
{

	/**
	 * All articles list
	 */
	public function renderDefault()
	{
		$this->template->articles = $this->orm->articles->findAll();
	}

	/**
	 * View particular article
	 */
	public function renderView($id)
	{
		$this->template->article = $this->orm->articles->getById($id);
	}


}
