<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Project;
use App\Models\Task;
use App\Services\TaskService;
use App\Supports\ResponseSupport;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param int $project
     * @param TaskService $service
     * @return JsonResponse
     */
    public function index(int $project, TaskService $service)
    {
        try {
            return ResponseSupport::success([
                ...$service->index($project)
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
     * @param Project $project
     * @param StoreTaskRequest $request
     * @param TaskService $service
     * @return JsonResponse
     */
    public function store(Project $project, StoreTaskRequest $request, TaskService $service): JsonResponse
    {
        try {
            $service->store($project, $request->validated());

            return ResponseSupport::success([
                'message' => __('response.'.'New task created')
            ]);

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ResponseSupport::error([
                'message' => __('response.'.'Something went wrong')
            ]);
        }
    }

    /**
     * Display the specified resource
     *
     * @param int $project
     * @param Task $task
     * @return JsonResponse
     */
    public function show(int $project, Task $task): JsonResponse
    {
        try {
            return ResponseSupport::success([
                'task' => new TaskResource($task)
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
     *
     * @param int $project
     * @param Task $task
     * @param UpdateTaskRequest $request
     * @param TaskService $service
     * @return JsonResponse
     */
    public function update(int $project, Task $task, UpdateTaskRequest $request, TaskService $service)
    {
        try {
            $service->update($task, $request->validated());

            return ResponseSupport::success([
                'message' => __('response.' . 'Task updated')
            ]);

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ResponseSupport::error([
                'message' => __('response.' . 'Something went wrong')
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $project
     * @param Task $task
     * @param TaskService $service
     * @return JsonResponse
     * @throws Throwable
     */
    public function destroy(int $project, Task $task, TaskService $service): JsonResponse
    {
        try {
            $service->destroy($task);

            return ResponseSupport::success([
                'message' => __('response.'.'Task deleted')
            ]);

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ResponseSupport::error([
                'message' => __('response.'.'Something went wrong')
            ]);
        }
    }
}
