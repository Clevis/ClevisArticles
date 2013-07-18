<?php

namespace App;

/**
 * Maps articles to database
 *
 * @method Orm\DibiCollection findAll()
 * @method Orm\DibiCollection fluentFindAll()
 */
class ArticlesMapper extends Mapper
{

	/**
	 * Returns all articles in fluent.
	 */
	public function fluentFindAll()
	{
		return parent::fluentFindAll();
	}

}
