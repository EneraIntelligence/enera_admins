<?php

namespace Admins;

use Jenssegers\Mongodb\Model;

class Branche extends Model
{
    protected $fillable = ['name', 'network_id', 'portal', 'aps', 'status'];

    // relations
    public function network()
    {
        return $this->belongsTo('Admins\Network');
    }

    public function campaign_logs()
    {
        return $this->hasMany('Admins\CampaignLog', 'device.branch_id');
    }
    // end relations
}
