<?php

namespace Admins;

use Jenssegers\Mongodb\Model;

class MassiveMailList extends Model
{
    protected $fillable = ['name', 'filters', 'administrator_id', 'status'];

    // relations
    public function administrator()
    {
        return $this->belongsTo('Admins\Administrator');
    }

    public function massivemail()
    {
        return $this->hasMany('Admins\MassiveMail', 'list_id');
    }
    // end relations
}
