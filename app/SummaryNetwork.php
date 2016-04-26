<?php

namespace Admins;

use Jenssegers\Mongodb\Model;

class SummaryNetwork extends Model
{
    protected $fillable = ['network_id', 'client_id', 'devices', 'users', 'interactions'];

    // relations
    public function network()
    {
        return $this->belongsTo('Admins\Nerwork');
    }

    public function client()
    {
        return $this->belongsTo('Admins\Client');
    }
    // end relations
}
