<?php

namespace Admins;

use Jenssegers\Mongodb\Model;

class AdministratorMovement extends Model
{
    protected $fillable = ['administrator_id', 'client_id', 'movement', 'reference_id', 'reference_type', 'amount', 'balance'];

    // relations
    public function admin()
    {
        return $this->belongsTo('Admins\Administrator');
    }

    public function client()
    {
        return $this->belongsTo('Admins\Client');
    }

    public function reference()
    {
        return $this->morphTo();
    }
    // end relations
}
