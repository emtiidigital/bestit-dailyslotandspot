<?php

namespace App\Console\Commands;

use App\Helper\FindSlots;
use App\Reminder;
use App\Worker;
use Bestit\HipChat\Facade\HipChat;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bestit:send:workers_Message';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send all workers a reminder message for the Daily meeting';

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
     * @throws \Exception
     */
    public function handle()
    {
        /** @var Reminder $reminder to get the last notified project */
        $reminder = \App\Reminder::find(1);
        $beginningTime = Carbon::parse($reminder->beginning_time)->subMinutes($reminder->hip_chat)->format('H:i');
        $endTime = Carbon::parse($reminder->end_time)->format('H:i');
        $now = Carbon::now('UTC')->format('H:i');

        if ($now < $beginningTime || $now > $endTime) {
            var_dump("hi");
            return;
        }

        $findSlots = new FindSlots();
        $coll = $findSlots->getSlotAndSpot();

        $filtered = $coll->where('position', $reminder->last_position);
        /** check if there are no any more project to reset the last position to 1 */
        $reminder->last_position += 1;
        $reminder->save();

        /** Go through all project in the given position and send all workers a message*/
        foreach ($filtered->all() as $project) {
            foreach ($project['workers'] as $worker) {
                $workerObject = Worker::where('name', $worker)->first();
                HipChat::user($workerObject->email)->notify('GO GO GO ' . $project['project'] . ' Daily! (success)  Room : ' . $project['room'],
                    true);
            }
        }
    }
}
