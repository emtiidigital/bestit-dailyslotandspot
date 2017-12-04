<?php

namespace App\Http\Controllers;

use App\Project;
use App\Worker;
use Bestit\HipChat\Facade\HipChat;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Input;

class SlotAndSpot extends Controller
{

    public $coll = [];

    public function addWorker()
    {

        $worker = Worker::where('name', Input::get('workerName'))->first();

        if (!$worker) {
            $worker = new Worker([
                'name' => Input::get('workerName'),
                'email' => Input::get('workerEmail')
            ]);
            $worker->save();
        }

        return back();
    }

    public function addProject()
    {

        $project = Project::where('name', Input::get('projectName'))->first();

        if (!$project) {
            $project = new Project(['name' => Input::get('projectName')]);
            $project->save();
        }

        return back();
    }

    public function addWorkerToProject($id)
    {
        $project = Project::find($id);
        $worker = Worker::find(Input::get('workerName'));
        if (!$worker->projects()->find($project->id)) {
            $worker->projects()->save($project);
            HipChat::user($worker->email)->notify('Nerd We need your support for '.$project->name . ' Project!');
        } else {
            return back()
                ->withErrors([
                    'Allready exist' => 'Worker does not exist : ',
                ], 'loginErrors');
        }

        return back();
    }

    public function deleteWorkerFromProject($id, $workerId)
    {
        $project = Project::find($id);
        $worker = Worker::find($workerId);
        if ($worker->projects()->find($project->id)) {
            $worker->projects()->detach($project);
            HipChat::user($worker->email)->notify('You have been kicked out form '.$project->name . ' Project!');
        }

        return back();
    }

    public function deleteProject($id)
    {
        Project::find($id)->delete();
        return back();
    }

    public function deleteWorker($id)
    {
        Worker::find($id)->delete();
        return back();
    }

    /**
     *
     */
    public function dailySpotAndSlot()
    {
        $projects = Project::all();

        foreach ($projects as $project) {
            $workers = $project->workers;
            $array = [
                'project' => $project->name,
                'position' => 0,
                'workers' => [],
                'conflict' => []
            ];
            foreach ($workers as $worker) {
                $array['workers'][] = $worker->name;
            }
            $this->coll[] = $array;
        }

        $this->findConflicts($this->coll);
        $this->findSlot($this->coll);


        $this->coll = Collection::make($this->coll)->sortBy('position');

        return view('SlotAndSpot', [
            'coll' => $this->coll,
            'previousValue' => $this->coll->first()['position'],
        ]);
    }

    public function findConflicts($array)
    {
        $count = count($array);

        for ($j = 0; $j < $count; $j++) {

            for ($i = $j + 1; $i < $count; $i++) {

                $result = !empty(array_intersect($array[$j]["workers"], $array[$i]["workers"]));

                if ($result) {
                    $array[$j]["conflict"][] = $array[$i]["project"];
                    $array[$i]["conflict"][] = $array[$j]["project"];
                }
            }
        }

        $this->coll = $array;
    }

    public function findSlot($array)
    {
        $count = count($array);

        for ($j = 0; $j < $count; $j++) {

            if (!empty($array[$j]["conflict"])) {

                $array[$j]["position"] = 1;

                $conflictCount = count($array[$j]["conflict"]);

                for ($i = 0; $i < $conflictCount; $i++) {

                    $value = $array[$j]["conflict"][$i];

                    for ($x = 0; $x < $count; $x++) {

                        if ($array[$x]['project'] === $value) {

                            if ($array[$j]["position"] === $array[$x]['position']) {
                                $array[$j]["position"] = $array[$j]["position"] + 1;
                            }

                            if ($array[$j]["position"] < $array[$x]['position']) {

                                if ($array[$x]['position'] == count($array[$j]["conflict"]) + 1) {

                                    if (count($array[$j]["conflict"]) - 1 == 0) {
                                        $array[$j]["position"] = 1;
                                    } else {
                                        $array[$j]["position"] = count($array[$j]["conflict"]) - 1;
                                    }

                                } else {
                                    $array[$j]["position"] = count($array[$j]["conflict"]) + 1;
                                }
                            }
                        }
                    }
                }

            } else {
                $array[$j]["position"] = 1;
            }

        }
        $this->coll = $array;
    }
}
