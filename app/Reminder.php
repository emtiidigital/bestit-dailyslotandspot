<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    //TODO: rename modal
    public $timestamps = false;
    protected $table = 'reminders';

    protected $fillable = ['last_position', 'max_spots', 'beginning_time', 'end_time', 'hip_chat'];
}
