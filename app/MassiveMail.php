<?php

namespace Admins;

use Jenssegers\Mongodb\Model;

class MassiveMail extends Model
{
    protected $fillable = ['list_id', 'content', 'sender', 'administrator_id', 'sent', 'analytics'];

    // relations
    public function administrator()
    {
        return $this->belongsTo('Admins\Administrator');
    }

    public function filters()
    {
        return $this->belongsTo('Admins\MassiveMailList', 'list_id');
    }
    // end relations
}
