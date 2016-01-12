<?php

namespace Admins;

use Jenssegers\Mongodb\Model;

class Interaction extends Model
{
    protected $fillable = ['name', 'rules', 'status'];

    // relations
    public function campaigns()
    {
        return $this->hasMany('Admins\Campaign', 'interaction.id');
    }
    // end relations
}
