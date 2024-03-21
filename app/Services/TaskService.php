<?php

namespace App\Services;

use App\Http\Resources\TaskResource;
use App\Models\Task;
use Throwable;

class TaskService
{
    /**
     * @param $project
     * @return array
     */
    public function index($project): array
    {
        $tasks = Task::where('project_id', $project)->paginate(2);

        return [
            'tasks' => TaskResource::collection($tasks),
            'links' => [
                'next_url' => $tasks->nextPageUrl(),
                'prev_url' => $tasks->previousPageUrl(),
            ],
            'meta' => [
                'total_pages' => $tasks->lastPage(),
                'total_items' => $tasks->total(),
            ],
        ];
    }

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
     * @param $data
     * @return void
     */
    public function update(Task $task, $data): void
    {
        $task->update($data);
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
