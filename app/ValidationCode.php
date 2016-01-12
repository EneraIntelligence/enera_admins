<?php

namespace Admins;

use Jenssegers\Mongodb\Model;

class ValidationCode extends Model
{
    protected $fillable = ['administrator_id', 'type', 'token'];
    //
}
