<?php

namespace App\Http\Controllers;

use App\Helper\FindSlots;
use App\Project;
use App\Worker;
use Bestit\HipChat\Facade\HipChat;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Input;

class SlotAndSpot extends Controller
{

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * @return RedirectResponse
     */
    public function addProject(): RedirectResponse
    {

        $project = Project::where('name', Input::get('projectName'))->first();

        if (!$project) {
            $project = new Project(['name' => Input::get('projectName')]);
            $project->save();
        }

        return back();
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function addWorkerToProject(int $id): RedirectResponse
    {
        $project = Project::find($id);
        $worker = Worker::find(Input::get('workerName'));
        if (!$worker->projects()->find($project->id)) {
            $worker->projects()->save($project);
            HipChat::user($worker->email)->notify('(jobs) Nerd you have been assigned to the ' . $project->name . ' Project!', true);
        } else {
            return back()
                ->withErrors([
                    'Allready exist' => 'Worker does not exist : ',
                ], 'loginErrors');
        }

        return back();
    }

    /**
     * @param int $id
     * @param int $workerId
     * @return RedirectResponse
     */
    public function deleteWorkerFromProject(int $id, int $workerId): RedirectResponse
    {
        $project = Project::find($id);
        $worker = Worker::find($workerId);
        if ($worker->projects()->find($project->id)) {
            $worker->projects()->detach($project);
            HipChat::user($worker->email)->notify('You have been kicked out from ' . $project->name . ' Project! (facepalm)', true);
        }

        return back();
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function deleteProject(int $id): RedirectResponse
    {
        Project::find($id)->delete();
        return back();
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function deleteWorker(int $id): RedirectResponse
    {
        Worker::find($id)->delete();
        return back();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function dailySpotAndSlot()
    {
        $findSlots = new FindSlots();
        $coll = $findSlots->getSlotAndSpot();

        return view('SlotAndSpot', [
            'coll' => $coll,
            'previousValue' => $coll->first()['position'],
        ]);
    }
}
