<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Services\ProjectService;
use App\Supports\ResponseSupport;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Log;
use Throwable;

class ProjectController extends Controller
{
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
            Log::error($e->getMessage());
            return ResponseSupport::error([
                'message' => __('response.' . 'Something went wrong')
            ]);
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
            Log::error($e->getMessage());
            return ResponseSupport::error([
                'message' => __('response.' . 'Something went wrong')
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        try {
            return ResponseSupport::success([
                'project' => new ProjectResource($project)
            ]);

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ResponseSupport::error([
                'message' => __('response.' . 'Something went wrong')
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Project $project, UpdateProjectRequest $request, ProjectService $service)
    {
        try {
            $service->update($project, $request->validated());

            return ResponseSupport::success([
                'message' => __('response.' . 'Project updated')
            ]);

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ResponseSupport::error([
                'message' => __('response.' . 'Something went wrong')
            ]);
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
            Log::error($e->getMessage());
            return ResponseSupport::error([
                'message' => __('response.' . 'Something went wrong')
            ]);
        }
    }
}
