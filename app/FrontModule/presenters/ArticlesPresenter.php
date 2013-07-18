<?php

namespace App\Front;

use	Nette\Utils\Strings;

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
	public function renderView($articleId, $articleTitle)
	{
		/** @var Article $article */
		$article = $this->orm->articles->getById($articleId);
		if (!$article)
		{
			$this->error();
		}

		// redirect to correct article title
		$webName = Strings::webalize($article->title);
		if ($articleTitle !== $webName)
		{
			$this->redirect('this', array(
				'articleId' => $article->id,
				'articleTitle' => $webName
			));
		}


		$this->template->article = $this->orm->articles->getById($articleId);
	}


}
