<?php

namespace Admins;

use Jenssegers\Mongodb\Model;

class CampaignLogInteraction extends Model
{
    protected $fillable = ['welcome', 'joined', 'requested', 'loaded', 'completed'];
    protected $collection = null;
    // relations

    // end relations
}
