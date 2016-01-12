<?php

namespace Admins;

use Jenssegers\Mongodb\Model;

class User extends Model
{
    protected $fillable = ['facebook'];

    // relations
    public function facebook()
    {
        return $this->embedsOne('Admins\UserFacebook');
    }
    // end relations
}
