<?php

namespace App;

use Orm;

/**
 * Repository containing articles
 *
 * @method Orm\DibiCollection findAll()
 * @method Orm\DibiCollection findVisible()
 */
class ArticlesRepository extends Repository
{

	public function findAllForDatagrid()
	{
		return $this->mapper->fluentFindAll();
	}

}
