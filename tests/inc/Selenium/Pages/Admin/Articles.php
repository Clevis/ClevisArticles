<?php

namespace Tests\Selenium\Pages\Admin;

use Se34\PageObject;
use Se34\Element;


/**
 * Stránka se články.
 *
 * @property-read Element[] $datagridRows xpath="//table[@id='articles-datagrid']//tbody//tr"
 *
 * @author Tomáš Sušánka
 */
class Articles extends PageObject
{

	protected $presenterName = 'Admin:Articles';


	public function getDatagridCell($row, $column)
	{
		return $this->datagridRows[$row]->element($this->session->using('xpath')->value("//td[$column]"));
	}

	/**
	 * @return ArticlesEdit
	 */
	public function editArticle($number)
	{
		$this->getDatagridCell($number, 1)->element($this->session->using('xpath')->value("a"))->click();
		$this->session->waitForAjax();
		return $this->getNextPage();
	}

	/**
	 * @return \Tests\Selenium\Pages\Front\Articles
	 */
	public function clickArticleAnchor($number)
	{
		$this->getDatagridCell($number, 4)->element($this->session->using('xpath')->value("a[1]"))->click();
		$this->session->waitForDocument();
		return $this->getNextPage();
	}

	/**
	 * @return \Tests\Selenium\Pages\Admin\Articles
	 */
	public function clickArticleDeleteButton($number)
	{
		$this->getDatagridCell($number, 4)->element($this->session->using('xpath')->value("a[2]"))->click();

		$this->session->waitForAlert();
		$this->session->acceptAlert();
		$this->session->waitForDocument();

		return $this->getNextPage();
	}

}
