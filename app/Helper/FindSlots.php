<?php

namespace App\Helper;

use App\Project;
use Illuminate\Support\Collection;

/**
 * Created by PhpStorm.
 * User: senan
 * Date: 05.01.18
 * Time: 16:43
 */
class FindSlots
{
    /** @var array */
    private $coll = [];

    /**
     * Get all projects and find the best order for the daily slots
     * @return Collection
     */
    public function getSlotAndSpot(): Collection
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

        return Collection::make($this->coll)->sortBy('position');
    }

    /**
     * This function finds all conflicts between the projects and save a new entry
     * to the conflict attribute.
     * @param $array
     */
    public function findConflicts(array $array)
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

    /**
     * This function iterates through the projects list and finds the best slot
     * by taking into consideration the conflicts with other projects
     * @param $array
     */
    public function findSlot(array $array)
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