<?php

namespace Admins;

use Jenssegers\Mongodb\Model;

class AccessPoint extends Model
{
    protected $fillable = ['name', 'mac', 'serial_number', 'location', 'branch_id', 'network_id', 'historic', 'status'];

    // relations
    public function branche()
    {
        return $this->belongsTo('Admins\Branche');
    }

    public function network()
    {
        return $this->belongsTo('Admins\Network');
    }
    // end relations
}
