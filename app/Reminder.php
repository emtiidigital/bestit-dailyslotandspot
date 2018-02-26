<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    public $timestamps = false;
    protected $table = 'reminders';

    protected $fillable = ['last_position'];
}
