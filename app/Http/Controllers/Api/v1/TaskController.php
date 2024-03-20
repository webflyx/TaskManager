<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
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
     */
    public function index()
    {
        //
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
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        //
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
