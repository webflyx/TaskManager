<?php

namespace App\Services;

use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Throwable;

class ProjectService
{

    /**
     * @return array
     */
    public function index(): array
    {

        $projects = Project::where('user_id', auth()->user()->id)->paginate(2);

        return [
            'projects' => ProjectResource::collection($projects),
            'links' => [
                'next_url' => $projects->nextPageUrl(),
                'prev_url' => $projects->previousPageUrl(),
            ],
            'meta' => [
              'total_pages' => $projects->lastPage(),
              'total_items' => $projects->total(),
            ],
        ];
    }

    /**
     * @param array $data
     * @return void
     */
    public function store(array $data): void
    {
        auth()->user()->projects()->create($data);
    }

    /**
     * @param Project $project
     * @param array $data
     * @return void
     */
    public function update(Project $project, array $data): void
    {
        $project->update($data);
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
