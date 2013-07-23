<?php

namespace Tests\Selenium\Pages\Admin;

use Se34\PageObject;
use Se34\Element;


/**
 * Stránka se články.
 *
 * @property-read Element[] $datagridRows xpath="//table[@id='articles-datagrid']//tbody//tr"
 *
 * @property-read Element  $title id=frm-editArticle-title, input, [type=text]
 * @property-read Element  $intro id=frm-editArticle-intro, textarea
 * @property-read Element  $text id=frm-editArticle-text, textarea
 * @property-read Element  $saveButton xpath="//input[@name='save']"
 *
 * @property-read Element  $backToArticles link text='Správa článků'
 *
 * @method ArticlesEdit clickSaveButton()
 * @method Articles clickBackToArticles()
 *
 * @author Tomáš Sušánka
 */
class ArticlesEdit extends PageObject
{

	protected $presenterName = 'Admin:Articles';
	protected $presenterParameters = 'action = edit';

	public function clear()
	{
		$this->title->clear();
		$this->intro->clear();
		$this->text->clear();
	}
}
