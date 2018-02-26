<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    protected $table = 'workers';
    protected $fillable = ['name', 'email'];

    public function projects()
    {
        return $this->belongsToMany('App\Project');
    }
}
