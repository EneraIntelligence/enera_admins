<?php

namespace Admins;

use Jenssegers\Mongodb\Model;

class Zone extends Model
{
    protected $fillable = ['name', 'aps', 'network_id', 'zones'];

    // relations
    public function network()
    {
        return $this->belongsTo('Admins\Network');
    }

    public function zones()
    {
        return $this->embedsMany('Admins\ZoneZone');
    }
    // end relations
}
