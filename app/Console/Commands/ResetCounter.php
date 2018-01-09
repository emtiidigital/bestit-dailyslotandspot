<?php

namespace App\Console\Commands;

use App\Reminder;
use Illuminate\Console\Command;

class ResetCounter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bestit:reset:Reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'reset the Reminder counter';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $reminder = Reminder::find(1);
        $reminder->last_position = 1;
        $reminder->save();
    }
}
