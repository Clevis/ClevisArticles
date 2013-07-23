<?php

namespace Tests\Selenium;

use \Tests\Selenium\Pages;

/**
 * Test článků.
 *
 * @author Tomas Susanka
 */
class Articles_Test extends SeleniumTestCase
{

	/**
	 * Testuje editaci článk.
	 * Využívá Authentication feature.
	 *
	 * @author Tomas Susanka
	 */
	public function testEditArticle()
	{
		$result = $this->auth->login(
			$this->context->parameters['selenium']['testUser']['username'],
			$this->context->parameters['selenium']['testUser']['password']
		);
		$this->assertTrue($result);

		$articles = new Pages\Admin\Articles($this->session);
		$articleEdit = $articles->editArticle(1);

		$articleEdit->clear();

		$articleEdit->fill(array(
				'title' => 'Hrušky jsou rekordně levné',
				'intro' => 'a nikdo neví proč',
				'text' => 'text článku o hruškách',
			));
		$articleEdit->clickSaveButton();

		$this->assertFlashMessage('Článek byl úspěšně uložen.');

		$articles = $articleEdit->clickBackToArticles();
		$article = $articles->clickArticleAnchor(1);

		$this->assertSame($article->title->text(), 'Hrušky jsou rekordně levné');
	}

}
