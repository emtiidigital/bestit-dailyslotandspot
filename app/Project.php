<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public $timestamps = false;
    protected $table = 'projects';

    protected $fillable = ['name', 'room'];

    public function workers()
    {
        return $this->belongsToMany('App\Worker');
    }
}
