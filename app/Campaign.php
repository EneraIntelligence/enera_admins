<?php

namespace Admins;

use Jenssegers\Mongodb\Model;

class Campaign extends Model
{
    protected $fillable = ['client_id', 'administrator_id', 'name', 'branches', 'interaction', 'filters', 'content', 'balance', 'status'];

    // relations
    public function administrator()
    {
        return $this->belongsTo('Admins\Administrator');
    }

    public function interaction()
    {
        return $this->belongsTo('Admins\Interaction', 'interaction.id');
    }

    public function logs()
    {
        return $this->hasMany('Admins\CampaignLog');
    }

    public function history()
    {
        return $this->embedsMany('Admins\CampaignHistory', 'history');
    }
    // end relations
}
