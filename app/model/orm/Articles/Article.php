<?php

namespace App;

use Orm;

/**
 * Entity representing one Article
 *
 * @property string $title
 * @property string $intro
 * @property string $text
 * @property DateTime $createdAt {default now}
 * @property bool $visible {default true}
 *
 * @property App\User $createdBy {m:1 App\UsersRepository $articles}
 *
 */
class Article extends Entity
{

}
