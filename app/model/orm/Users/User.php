<?php

namespace App;


/**
 * Entity representing one user
 *
 * @property string $username
 * @property string $password
 *
 * @property Orm\OneToMany $articles {1:m App\ArticlesRepository $createdBy}
 *
 */
class User extends Entity
{

}
