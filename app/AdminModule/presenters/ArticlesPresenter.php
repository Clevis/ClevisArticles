<?php

namespace App\Admin;

use Nette\Application\UI\Form,
	App\Article,
	Nette\Utils\Html;


/**
 * Articles editting presenter
 */
final class ArticlesPresenter extends BasePresenter
{

	public function renderDefault()
	{
		$this->template->articles = $this->orm->articles->findAll();
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
		$this->redirect('Articles:edit', $article->id);
	}

}
