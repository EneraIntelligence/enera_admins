<?php

namespace Admins;

use Jenssegers\Mongodb\Model;

class Role extends Model
{
    protected $fillable = ['name', 'platform', 'permissions', 'client_id'];

    // relations
    public function client()
    {
        return $this->belongsTo('Admins\Client');
    }
    // end relations
}
