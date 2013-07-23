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

	/**
	 * Testuje vymazání článku.
	 * Využívá Authentication feature.
	 *
	 * @author Tomas Susanka
	 */
	public function testDeleteArticle()
	{
		$result = $this->auth->login(
			$this->context->parameters['selenium']['testUser']['username'],
			$this->context->parameters['selenium']['testUser']['password']
		);
		$this->assertTrue($result);

		$articles = new Pages\Admin\Articles($this->session);

		$this->assertSame($articles->getDatagridCell(1, 1)->text(), 'Jak zlepšit život v důchodu a stáří');

		$articles->clickArticleDeleteButton(1);

		$this->assertFlashMessage('Článek byl úspěšně smazán.');

		$this->assertSame($articles->getDatagridCell(1, 1)->text(), 'Dechová zkouška není důkazem');
	}

	/**
	 * Testuje editaci článk.
	 * Využívá Authentication feature.
	 *
	 * @author Tomas Susanka
	 */
	public function testTexy()
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
				'title' => 'A',
				'intro' => 'a',
				'text' => '//italic test//',
			));

		$articleEdit->clickSaveButton();

		$this->assertFlashMessage('Článek byl úspěšně uložen.');

		$articles = $articleEdit->clickBackToArticles();
		$article = $articles->clickArticleAnchor(1);

		$this->assertSame($article->italic->text(), 'italic test');
	}

}
