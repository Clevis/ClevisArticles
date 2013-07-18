<?php

namespace App\Admin;

use Nette\Application\Routers\Route;
use Nette\Application\Routers\RouteList;


class Router extends RouteList
{

	public function __construct($module = 'Admin', $prefix = 'admin')
	{
		parent::__construct($module);

		$this[] = new Route($prefix, 'Home:default');
		$this[] = new Route('<presenter>/<action>[/<id>]', 'Homepage:default');
	}

}
