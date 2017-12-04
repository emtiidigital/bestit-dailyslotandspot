<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    public $timestamps = false;
    protected $table = 'workers';

    protected $fillable = ['name', 'email'];

    public function projects() {
        return $this->belongsToMany('App\Project');
    }

}
