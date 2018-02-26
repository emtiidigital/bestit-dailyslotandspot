<?php

namespace App\Helper;

use App\Project;
use Illuminate\Support\Collection;

/**
 * Created by PhpStorm.
 * User: SenanSharhan
 * Date: 05.01.18
 * Time: 16:43
 */
class FindSlots
{
    /** @var array $allProjects */
    private $allProjects = [];
    /** @var array $sortedProjects */
    private $sortedProjects = [];

    /**
     * Get all projects and find the best order for the daily slots
     * @return Collection
     */
    public function getSlotAndSpot(): Collection
    {
        $projects = Project::all();

        foreach ($projects as $project) {
            $workers = $project->workers;
            $allProjects = [
                'project' => $project->name,
                'position' => 0,
                'workers' => $workers->pluck('name')->toArray(),
                'conflict' => []
            ];

            $this->allProjects[] = $allProjects;
        }

        $this->findConflicts($this->allProjects);
        $this->findSlot($this->allProjects);

        return Collection::make($this->sortedProjects)->sortBy('position');
    }

    /**
     * This function finds all conflicts between the projects and save a new entry
     * to the conflict attribute.
     * @param array $allProjects
     */
    public function findConflicts(array $allProjects)
    {

        $count = count($allProjects);

        for ($j = 0; $j < $count; $j++) {

            for ($i = $j + 1; $i < $count; $i++) {

                $result = !empty(array_intersect($allProjects[$j]['workers'], $allProjects[$i]['workers']));

                if ($result) {
                    $allProjects[$j]['conflict'][] = $allProjects[$i]['project'];
                    $allProjects[$i]['conflict'][] = $allProjects[$j]['project'];
                }
            }
        }

        $this->allProjects = $allProjects;
    }

    /**
     * This function iterates through the projects list and finds the best slot
     * by taking into consideration the conflicts with other projects
     * @param $allProjects
     */
    public function findSlot(array $allProjects)
    {
        foreach ($allProjects as $key => $projectToAdd) {

            if ($key === 0) {
                $this->sortedProjects[] = $projectToAdd;
            } else {
                $this->findPosition($projectToAdd);
            }
        }
    }

    /**
     * @param $projectToAdd
     */
    public function findPosition(array $projectToAdd)
    {
        foreach ($this->sortedProjects as $project) {
            if (in_array($projectToAdd['project'], $project['conflict'], true)) {
                $projectToAdd['position'] = $project['position'] + 1;
            }
        }

        $this->sortedProjects[] = $projectToAdd;
    }
}