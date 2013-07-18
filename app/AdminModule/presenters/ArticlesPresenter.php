<?php

namespace App\Admin;

use Grido,
	Grido\Components\Columns\Column,
	Nette\Application\UI\Form,
	App\Article;


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

		$grid->addColumnText('title', 'Titulek')
			 ->headerPrototype->style = 'width: 40%'; // todo
		$grid->addColumnText('created_at', 'Vytvořeno')
			 ->headerPrototype->style = 'width: 20%';
		$grid->addColumnText('visible', 'Viditelné')
			 ->headerPrototype->style = 'width: 1%';

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
		$this->template->heading = 'Přidat článek';
		$this->view = 'edit';
	}

	/**
	 * Article editting
	 * @param  int
	 */
	public function actionEdit($id)
	{
		$article = $this->orm->articles->getById($id);
		$this->template->heading = 'Article editting';

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

		$form->addText('title', 'Titulek')
			->setRequired('Prosím vyplňte titulek.');
		$form->addTextArea('intro', 'Perex');
		$form->addTextArea('text', 'text');

		$form->addCheckbox('visible', 'Viditelné');

		$form->addSubmit('save', 'Uložit');

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
