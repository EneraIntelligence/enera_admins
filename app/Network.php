<?php

namespace Admins;

use Jenssegers\Mongodb\Model;

class Network extends Model
{
    protected $fillable = ['name', 'type', 'main', 'status'];

    // relations
    public function branches()
    {
        return $this->hasMany('Admins\Branche');
    }
    // end relations
}
