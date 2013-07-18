<?php

namespace App\Admin;

use Nette\Application\UI\Form,
	App\Article;


/**
 * Articles editting presenter
 */
final class ArticlesPresenter extends BasePresenter
{

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
