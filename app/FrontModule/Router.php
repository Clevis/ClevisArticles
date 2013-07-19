<?php

namespace App\Front;

use Nette\Application\Routers\Route,
	Nette\Application\Routers\RouteList,
	Nette\Utils\Strings;


class Router extends RouteList
{

	public function __construct($module = 'Front')
	{
		parent::__construct($module);

		// article detail
		Route::addStyle('articleTitle');
		Route::setStyleProperty('articleTitle', Route::FILTER_OUT, function($title) {
			return Strings::webalize($title);
		});
		Route::setStyleProperty('articleTitle', Route::FILTER_IN, function($title) {
			return Strings::webalize($title);
		});

		$this[] = new Route('<presenter>/<articleId [0-9]+>-<articleTitle>', 'Articles:view');


		$this[] = new Route('<presenter>/<action>[/<id>]', 'Homepage:default');
	}

}
