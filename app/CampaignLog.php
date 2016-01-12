<?php

namespace Admins;

use Jenssegers\Mongodb\Model;

class CampaignLog extends Model
{
    protected $fillable = ['user', 'device', 'interaction', 'cost'];

    // relations
    public function campaign()
    {
        return $this->belongsTo('Admins\Campaign');
    }

    public function interaction()
    {
        return $this->embedsOne('Admins\CampaignLogInteraction');
    }

    public function user() // presenta inconsistencia
    {
        return $this->belongsTo('Admins\User','user.id');
    }
    // end relations


}