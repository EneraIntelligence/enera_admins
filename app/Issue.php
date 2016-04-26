<?php

namespace Admins;

use Jenssegers\Mongodb\Model as Model;

class Issue extends Model
{
    protected $fillable = ['issue', 'exception', 'statistic', 'recurrence', 'responsible_id', 'priority', 'status', 'history'];
    protected $dates = ['created_at', 'updated_at'];

    // relations
    public function reponsible()
    {
        return $this->belongsTo('Admins\Administrator', 'responsible_id');
    }

    public function recurrence()
    {
        return $this->embedsMany('Admins\IssueRecurrence');
    }

    /*public function statistic()
    {
        return $this->embedsMany('Admins\IssueStatistic');
    }*/
    // end relations
}
