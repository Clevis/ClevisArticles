<?php

namespace App\Admin;

use Grido,
	Grido\Components\Columns\Column,
	Nette\Application\UI\Form,
	App\Article,
	Nette\Utils\Html;


/**
 * Articles editting presenter
 */
final class ArticlesPresenter extends BasePresenter
{


	/**
	 * Datagrid for articles
	 * @param
	 */
	protected function createComponentGrid($name)
	{
		$grid = new Grido\Grid($this, $name);

		$grid->setTemplateFile(__DIR__ . '/../templates/components/grid.latte');

		$grid->addColumnText('title', 'Titulek');
		$grid->addColumnText('created_at', 'Vytvořeno');
		$grid->addColumnText('visible', 'Viditelné')
			->setCustomRender(function ($article) {
				$el = Html::el('i');
				$el->class = $article->visible ? 'glyphicon glyphicon-ok' : 'glyphicon glyphicon-remove';
				return $el;
			});

		$grid->addActionHref('edit', 'Edit')
			->setIcon('pencil');

		$grid->addActionHref('delete', 'Delete')
			->setIcon('trash')
			->setConfirm(function($item) {
				return 'Opravdu chcete smazat ' . $item->title . ' ?';
			});

		$grid->setModel($this->orm->articles->findAllForDatagrid());
	}

	/**
	 * Adding an article
	 */
	public function actionAdd()
	{
		$this->template->heading = 'Nový článek';
		$this->view = 'edit';
	}

	/**
	 * Removing an article
	 */
	public function actionDelete($id)
	{
		$this->orm->articles->remove($id);
		$this->orm->flush();

		$this->flashMessage('Článek byl úspěšně smazán.');
		$this->redirect('Articles:');
	}

	/**
	 * Article editting
	 * @param  int
	 */
	public function actionEdit($id)
	{
		$article = $this->orm->articles->getById($id);
		$this->template->heading = 'Editace článku';

		$this['editArticle']->setDefaults($article);
	}

	/**
	 * Form for editting and adding articles
	 * @return Nette\Form
	 */
	protected function createComponentEditArticle()
	{
		$form = new Form;

		$form->addHidden('id');

		$form->addText('title', 'Název článku')
			->setRequired('Prosím vyplňte titulek.')
			->setAttribute('placeholder', 'Název článku');
		$form->addTextArea('intro', 'Perex')->setAttribute('placeholder', 'Perex');
		$form->addTextArea('text', 'Obsah')->setAttribute('placeholder', 'Obsah');

		$form->addCheckbox('visible', 'Viditelné');

		$form->addSubmit('save', 'Uložit článek');

		$form->onSuccess[] = callback($this, 'editArticleFormSubmitted');

		return $form;
	}

	/**
	 * Form processing
	 */
	public function editArticleFormSubmitted(Form $form)
	{
		$values = $form->getValues();

		if (empty($values->id))
		{
			$article = new Article();
			$this->orm->articles->attach($article);
			$article->setValues($form->values);
		}
		else
		{
			$article = $this->orm->articles->getById($values->id);
			$article->setValues($values);
		}

		$article->createdBy = $this->user->id;

		$this->orm->articles->flush();

		$this->flashMessage('Článek byl úspěšně uložen.', 'success');
		$this->redirect('Articles:');
	}

}
