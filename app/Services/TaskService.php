<?php

namespace App\Services;

use App\Models\Task;
use Throwable;

class TaskService
{
    /**
     * @param $project
     * @param $data
     * @return void
     */
    public function store($project, $data): void
    {
        $project->tasks()->create($data);
    }

    /**
     * @param Task $task
     * @return void
     * @throws Throwable
     */
    public function destroy(Task $task): void
    {
        $task->deleteOrFail();
    }
}
