<?php

namespace App\Http\Controllers\Api\v1\Swagger;

use App\Http\Controllers\Controller;
use OpenApi\Annotations as OA;

/**
 * @OA\Get(
 *      path="/api/v1/projects/{project}/tasks",
 *      summary="Get project tasks",
 *      tags={"Tasks"},
 *      security={{ "bearerAuth": {} }},
 *
 *      @OA\Response(
 *          response="200",
 *          description="Successful response",
 *
 *          @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="projects", type="array",
 *             @OA\Items(
 *                 @OA\Property(property="id", type="integer", example=34),
 *                 @OA\Property(property="title", type="string", example="Task title"),
 *                 @OA\Property(property="description", type="string", example="Task descripion text"),
 *                 @OA\Property(property="status", type="string", example="new"),
 *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-03-23T11:36:41.000000Z"),
 *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-03-23T11:43:20.000000Z")
 *              )),
 *              @OA\Property(property="links", type="object",
 *                   @OA\Property(property="next_url", type="string", example="http://localhost:8000/api/v1/projects/8/tasks?page=2",
 *                   @OA\Property(property="prev_url", type="string", example=null)
 *              ),
 *              @OA\Property(property="meta", type="object",
 *                   @OA\Property(property="total_pages", type="integer", example=5),
 *                   @OA\Property(property="total_items", type="integer", example=10),
 *                   @OA\Property(property="per_page", type="integer", example=2),
 *                   @OA\Property(property="curr_page", type="integer", example=1)
 *              )
 *          )
 *      )
 *      ),
 *      @OA\Response(
 *           response="401",
 *           description="Auth error",
 *
 *           @OA\JsonContent(
 *               allOf={
 *                   @OA\Schema(
 *                       @OA\Property(property="success", type="boolean", example="false"),
 *                       @OA\Property(property="message", type="string", example="Unauthenticated"),
 *                   )
 *               }
 *           )
 *       ),
 * )
 *
 * @OA\Get(
 *      path="/api/v1/projects/{project}/tasks/{task}",
 *      summary="Get single task",
 *      tags={"Tasks"},
 *      security={{ "bearerAuth": {} }},
 *
 *     @OA\Parameter(
 *         name="project",
 *         in="path",
 *         description="Project ID",
 *         required=true,
 *         @OA\Schema(type="integer", example=2)
 *     ),
 *
 *     @OA\Parameter(
 *         name="task",
 *         in="path",
 *         description="Task ID",
 *         required=true,
 *         @OA\Schema(type="integer", example=2)
 *     ),
 *
 *      @OA\Response(
 *          response="200",
 *          description="Successful response",
 *
 *      @OA\JsonContent(
 *           @OA\Property(property="success", type="boolean", example="true"),
 *           @OA\Property(property="task", type="object",
 *               @OA\Property(property="id", type="integer", example=10),
 *               @OA\Property(property="title", type="string", example="Task title 1"),
 *               @OA\Property(property="status", type="string", example="new"),
 *               @OA\Property(property="description", type="string", example="Quam fugiat qui ad saepe vero qui. Omnis minus quam voluptas reprehenderit vel. Et dolorem temporibus quidem. Dolores voluptates omnis veritatis nihil mollitia."),
 *               @OA\Property(property="created_at", type="string", format="date-time", example="2024-03-21T11:06:22.000000Z"),
 *               @OA\Property(property="updated_at", type="string", format="date-time", example="2024-03-21T11:06:22.000000Z")
 *           )
 *        )
 *      ),
 *
 *      @OA\Response(
 *           response="401",
 *           description="Auth error",
 *
 *           @OA\JsonContent(
 *               allOf={
 *                   @OA\Schema(
 *                       @OA\Property(property="success", type="boolean", example="false"),
 *                       @OA\Property(property="message", type="string", example="Unauthenticated"),
 *                   )
 *               }
 *           )
 *       ),
 *  )
 *
 * @OA\Post(
 *      path="/api/v1/projects/{project}/tasks",
 *      summary="Create a new task",
 *      tags={"Tasks"},
 *      security={{ "bearerAuth": {} }},
 *
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             type="object",
 *             required={"title", "description", "status"},
 *
 *             @OA\Property(property="title", type="string", example="New Task"),
 *             @OA\Property(property="description", type="string", example="New task description"),
 *             @OA\Property(property="status", type="string", example="new"),
 *         ),
 *     ),
 *
 *      @OA\Response(
 *          response="200",
 *          description="Task successfully created.",
 *
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example="true"),
 * *           @OA\Property(property="message", type="string", example="New task created")
 *         ),
 *      ),
 *
 *      @OA\Response(
 *           response="401",
 *           description="Auth error",
 *
 *           @OA\JsonContent(
 *               allOf={
 *                   @OA\Schema(
 *                       @OA\Property(property="success", type="boolean", example="false"),
 *                       @OA\Property(property="message", type="string", example="Unauthenticated"),
 *                   )
 *               }
 *           )
 *       ),
 *
 *      @OA\Response(
 *          response="422",
 *          description="Validation Errors",
 *
 *          @OA\JsonContent(
 *              allOf={
 *                  @OA\Schema(
 *                      @OA\Property(property="message", type="string", example="The title field is required."),
 *                      @OA\Property(property="errors", type="object",
 *                          @OA\Property(property="title", type="array",
 *                              @OA\Items(type="string", example="The title field is required.")
 *                          )
 *                      )
 *                  )
 *              }
 *          )
 *      ),
 *  )
 *
 * @OA\Patch(
 *      path="/api/v1/projects/{project}/tasks/{task}",
 *      summary="Update a task",
 *      tags={"Tasks"},
 *      security={{ "bearerAuth": {} }},
 *
 *     @OA\Parameter(
 *         name="project",
 *         in="path",
 *         description="Project ID",
 *         required=true,
 *         @OA\Schema(type="integer", example=2)
 *     ),
 *
 *     @OA\Parameter(
 *         name="task",
 *         in="path",
 *         description="Task ID",
 *         required=true,
 *         @OA\Schema(type="integer", example=4)
 *     ),
 *
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             @OA\Property(property="title", type="string", example="Update Title Task"),
 *             @OA\Property(property="description", type="string", example="update task description"),
 *             @OA\Property(property="status", type="string", example="progress"),
 *     )),
 *
 *     @OA\Response(
 *         response="200",
 *         description="Update successfully",
 *
 *         @OA\JsonContent(
 *              @OA\Property(property="success", type="boolean", example="true"),
 *              @OA\Property(property="message", type="string", example="Task updated"),
 *         )
 *     ),
 *
 *     @OA\Response(
 *          response="422",
 *          description="Validation Errors",
 *
 *          @OA\JsonContent(
 *              allOf={
 *                  @OA\Schema(
 *                      @OA\Property(property="message", type="string", example="The title field is required."),
 *                      @OA\Property(property="errors", type="object",
 *                          @OA\Property(property="title", type="array",
 *                              @OA\Items(type="string", example="The title field is required.")
 *                          )
 *                      )
 *                  )
 *              }
 *          )
 *      ),
 *
 *      @OA\Response(
 *          response="404",
 *          description="Record not found",
 *              @OA\JsonContent(
 *                  @OA\Property(property="success", type="boolean", example="false"),
 *                  @OA\Property(property="message", type="string", example="Record not found")
 *            ),
 *       ),
 *
 *      @OA\Response(
 *          response="401",
 *          description="Auth error",
 *
 *          @OA\JsonContent(
 *              allOf={
 *                  @OA\Schema(
 *                      @OA\Property(property="success", type="boolean", example="false"),
 *                      @OA\Property(property="message", type="string", example="Unauthenticated"),
 *                  )
 *              }
 *          )
 *      ),
 *  )
 *
 * @OA\Delete(
 *      path="/api/v1/projects/{project}/tasks/{task}",
 *      summary="Delete a task",
 *      tags={"Tasks"},
 *      security={{ "bearerAuth": {} }},
 *
 *      @OA\Parameter(
 *          name="project",
 *          in="path",
 *          description="Project ID",
 *          required=true,
 *          @OA\Schema(type="integer", example=2)
 *      ),
 *
 *      @OA\Parameter(
 *          name="task",
 *          in="path",
 *          description="Task ID",
 *          required=true,
 *          @OA\Schema(type="integer", example=4)
 *      ),
 *
 *      @OA\Response(
 *          response="200",
 *          description="Task successfully deleted.",
 *
 *         @OA\JsonContent(
 *             type="object",
 *                 @OA\Property(property="success", type="boolean", example="true"),
 *                @OA\Property(property="message", type="string", example="Task deleted")
 *         ),
 *      ),
 *
 *      @OA\Response(
 *          response="404",
 *          description="Record not found",
 *              @OA\JsonContent(
 *                  @OA\Property(property="success", type="boolean", example="false"),
 *                  @OA\Property(property="message", type="string", example="Record not found")
 *            ),
 *       ),
 *
 *      @OA\Response(
 *          response="401",
 *          description="Auth error",
 *
 *          @OA\JsonContent(
 *              allOf={
 *                  @OA\Schema(
 *                      @OA\Property(property="success", type="boolean", example="false"),
 *                      @OA\Property(property="message", type="string", example="Unauthenticated"),
 *                  )
 *              }
 *          )
 *      ),
 *  )
 *
 */
class TaskController extends Controller
{

}
