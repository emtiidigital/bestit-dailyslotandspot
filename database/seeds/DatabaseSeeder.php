<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('reminders')->insert([
            'last_position' => 0,
            'max_spots' => 5,
            'beginning_time' => \Carbon\Carbon::createFromFormat('H:i', '9:10'),
            'end_time' => \Carbon\Carbon::createFromFormat('H:i', '10:30'),
            'hip_chat' => 1
        ]);

        /** Name, email, password should be changed */
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin'),
        ]);
    }
}
