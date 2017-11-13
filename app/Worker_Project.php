<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Worker_Project extends Model
{
    protected $table = 'project_worker';
    //

    public function projects()
    {
        return $this->belongsToMany('App\Project', 'project_worker',
            'worker_id', 'project_id');
    }

}
