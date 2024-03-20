<?php

namespace App\Services;

use App\Models\Project;
use Throwable;

class ProjectService
{
    /**
     * @param $data
     * @return void
     */
    public function store($data): void
    {
        auth()->user()->projects()->create($data);
    }

    /**
     * @param Project $project
     * @return void
     * @throws Throwable
     */
    public function destroy(Project $project): void
    {
        $project->deleteOrFail();
    }
}
