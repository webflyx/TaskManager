<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Services\ProjectService;
use App\Supports\ResponseSupport;
use App\Traits\ServerException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Throwable;

class ProjectController extends Controller
{
    use ServerException;
    /**
     * Display a listing of the resource.
     *
     * @param ProjectService $service
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function index(ProjectService $service): JsonResponse|AnonymousResourceCollection
    {
        try {
            return ResponseSupport::success([
                ...$service->index()
            ]);

        } catch (\Exception $e) {
            return self::serverException($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreProjectRequest $request
     * @param ProjectService $service
     * @return JsonResponse
     */
    public function store(StoreProjectRequest $request, ProjectService $service): JsonResponse
    {
        try {
            $service->store($request->validated());

            return ResponseSupport::success([
                'message' => __('response.' . 'New project created')
            ]);

        } catch (\Exception $e) {
            return self::serverException($e->getMessage());
        }
    }

    /**
     * Display the specified resource
     *
     * @param Project $project
     * @return JsonResponse
     */
    public function show(Project $project): JsonResponse
    {
        try {
            return ResponseSupport::success([
                'project' => new ProjectResource($project)
            ]);

        } catch (\Exception $e) {
            return self::serverException($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Project $project
     * @param UpdateProjectRequest $request
     * @param ProjectService $service
     * @return JsonResponse
     */
    public function update(Project $project, UpdateProjectRequest $request, ProjectService $service): JsonResponse
    {
        try {
            $service->update($project, $request->validated());

            return ResponseSupport::success([
                'message' => __('response.' . 'Project updated')
            ]);

        } catch (\Exception $e) {
            return self::serverException($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage
     *
     * @param Project $project
     * @param ProjectService $service
     * @return JsonResponse
     * @throws Throwable
     */
    public function destroy(Project $project, ProjectService $service): JsonResponse
    {
        try {
            $service->destroy($project);

            return ResponseSupport::success([
                'message' => __('response.' . 'Project deleted')
            ]);

        } catch (\Exception $e) {
            return self::serverException($e->getMessage());
        }
    }
}
