<?php

namespace App\Http\Controllers\Api\v1\Swagger;

use App\Http\Controllers\Controller;
use OpenApi\Annotations as OA;

/**
 * @OA\Get(
 *      path="/api/v1/projects/",
 *      summary="Get user projects",
 *      tags={"Projects"},
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
 *                 @OA\Property(property="title", type="string", example="New Project"),
 *                 @OA\Property(property="description", type="string", example="Project descripion text"),
 *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-03-23T11:36:41.000000Z"),
 *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-03-23T11:43:20.000000Z")
 *              )),
 *              @OA\Property(property="links", type="object",
 *                   @OA\Property(property="next_url", type="string", example="https://domain.com/api/v1/projects?page=2"),
 *                   @OA\Property(property="prev_url", type="string", example=null)
 *              ),
 *              @OA\Property(property="meta", type="object",
 *                   @OA\Property(property="total_pages", type="integer", example=5),
 *                   @OA\Property(property="total_items", type="integer", example=10),
 *                   @OA\Property(property="per_page", type="integer", example=2),
 *                   @OA\Property(property="curr_page", type="integer", example=1)
 *              )
 *          )
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
 * )
 *
 * @OA\Get(
 *      path="/api/v1/projects/{project}",
 *      summary="Get single project",
 *      tags={"Projects"},
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
 *      @OA\Response(
 *          response="200",
 *          description="Successful response",
 *
 *      @OA\JsonContent(
 *           @OA\Property(property="success", type="boolean", example=true),
 *           @OA\Property(property="project", type="object",
 *               @OA\Property(property="id", type="integer", example=10),
 *               @OA\Property(property="title", type="string", example="Walton Koelpin"),
 *               @OA\Property(property="description", type="string", example="Quam fugiat qui ad saepe vero qui. Omnis minus quam voluptas reprehenderit vel. Et dolorem temporibus quidem. Dolores voluptates omnis veritatis nihil mollitia."),
 *               @OA\Property(property="created_at", type="string", format="date-time", example="2024-03-21T11:06:22.000000Z"),
 *               @OA\Property(property="updated_at", type="string", format="date-time", example="2024-03-21T11:06:22.000000Z")
 *           )
 *        )
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
 *  )
 *
 * @OA\Post(
 *      path="/api/v1/projects/",
 *      summary="Create new project",
 *      tags={"Projects"},
 *      security={{ "bearerAuth": {} }},
 *
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             type="object",
 *             required={"title", "description"},
 *
 *             @OA\Property(property="title", type="string", example="New Project"),
 *             @OA\Property(property="description", type="string", example="new project description"),
 *         ),
 *     ),
 *
 *      @OA\Response(
 *          response="200",
 *          description="Post successfully created.",
 *
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example="true"),
 *             @OA\Property(property="message", type="string", example="New project created")
 *         ),
 *      ),
 *
 *       @OA\Response(
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
 *      path="/api/v1/projects/{project}",
 *      summary="Update a project",
 *      tags={"Projects"},
 *      security={{ "bearerAuth": {} }},
 *
 *     @OA\Parameter(
 *         name="project",
 *         in="path",
 *         description="Project ID",
 *         required=true,
 *         @OA\Schema(
 *             type="number",
 *         ),
 *     ),
 *
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             @OA\Property(property="title", type="string", example="Update Title Project"),
 *             @OA\Property(property="description", type="string", example="update project description"),
 *     )),
 *
 *     @OA\Response(
 *         response="200",
 *         description="Update successfully",
 *
 *         @OA\JsonContent(
 *              @OA\Property(property="success", type="boolean", example="true"),
 *              @OA\Property(property="message", type="string", example="Project updated"),
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
 *      path="/api/v1/projects/{project}",
 *      summary="Delete a project",
 *      tags={"Projects"},
 *      security={{ "bearerAuth": {} }},
 *
 *      @OA\Parameter(
 *          name="project",
 *          in="path",
 *          description="Project ID",
 *          required=true,
 *          @OA\Schema(
 *              type="number",
 *          ),
 *      ),
 *
 *      @OA\Response(
 *          response="200",
 *          description="Project successfully deleted.",
 *
 *         @OA\JsonContent(
 *             type="object",
 *                 @OA\Property(property="success", type="boolean", example="true"),
 *                @OA\Property(property="message", type="string", example="Project deleted")
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
class ProjectController extends Controller
{

}
