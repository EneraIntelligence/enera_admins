<?php

namespace Admins;

use Jenssegers\Mongodb\Model;

class Device extends Model
{
    protected $fillable = ['mac', 'os', 'manufacture', 'frecuency'];
    // relations

    // end relations
}
