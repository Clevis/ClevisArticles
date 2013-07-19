<?php

namespace App;

use Clevispace;


/**
 * Base presenter for all application presenters.
 *
 * @property-read RepositoryContainer $orm
 */
abstract class BasePresenter extends Clevispace\BasePresenter
{

	/**
	 * Returns RepositoryContainer.
	 *
	 * @author Jan Tvrdík
	 * @return RepositoryContainer
	 */
	public function getOrm()
	{
		return $this->context->getService('repositoryContainer');
	}

	/**
	 * Registers helperLoader
	 *
	 * @return Nette\Templating\ITemplate
	 */
	public function createTemplate($class = NULL)
	{
		$template = parent::createTemplate($class);
		$template->registerHelperLoader(callback($this->context->helperLoader, 'loader'));
		return $template;
	}

}
