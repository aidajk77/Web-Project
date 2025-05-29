<?php
require_once __DIR__ . '/../services/ApplicationsService.class.php';

$applicationService = new ApplicationService();

/**
 * @OA\Get(
 *     path="/applications",
 *     tags={"Applications"},
 *     summary="Get all applications",
 *     @OA\Response(
 *         response=200,
 *         description="List of all applications"
 *     ),
 *     security={{"ApiKey": {}}}
 * )
 */
Flight::route('GET /applications', function () use ($applicationService) {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    Flight::json($applicationService->get_all_applications());
});

/**
 * @OA\Get(
 *     path="/applications/{id}",
 *     tags={"Applications"},
 *     summary="Get application by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Application ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Application found"
 *     ),
 *     security={{"ApiKey": {}}}
 * )
 */
Flight::route('GET /applications/@id', function ($id) use ($applicationService) {
    Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::JOB_SEEKER, Roles::EMPLOYER]);
    Flight::json($applicationService->get_application_by_id($id));
});

/**
 * @OA\Post(
 *     path="/applications",
 *     tags={"Applications"},
 *     summary="Create new application",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"user_id", "job_id"},
 *             @OA\Property(property="user_id", type="integer"),
 *             @OA\Property(property="job_id", type="integer"),
 *             @OA\Property(property="status", type="string"),
 *             @OA\Property(property="cover_letter", type="string")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Application created successfully"
 *     ),
 *     security={{"ApiKey": {}}}
 * )
 */
Flight::route('POST /applications', function () use ($applicationService) {
    Flight::auth_middleware()->authorizeRole(Roles::JOB_SEEKER);
    $data = Flight::request()->data->getData();
    Flight::json($applicationService->create_application($data));
});

/**
 * @OA\Put(
 *     path="/applications/{id}",
 *     tags={"Applications"},
 *     summary="Update application",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Application ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string"),
 *             @OA\Property(property="cover_letter", type="string")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Application updated successfully"
 *     ),
 *     security={{"ApiKey": {}}}
 * )
 */
Flight::route('PUT /applications/@id', function ($id) use ($applicationService) {
    Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::JOB_SEEKER]);
    $data = Flight::request()->data->getData();
    Flight::json($applicationService->update_application($id, $data));
});

/**
 * @OA\Delete(
 *     path="/applications/{id}",
 *     tags={"Applications"},
 *     summary="Delete application",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Application ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Application deleted successfully"
 *     ),
 *     security={{"ApiKey": {}}}
 * )
 */
Flight::route('DELETE /applications/@id', function ($id) use ($applicationService) {
    Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::JOB_SEEKER]);
    Flight::json($applicationService->delete_application($id));
});

/**
 * @OA\Get(
 *     path="/applications/user/{user_id}",
 *     tags={"Applications"},
 *     summary="Get applications by user ID",
 *     @OA\Parameter(
 *         name="user_id",
 *         in="path",
 *         required=true,
 *         description="User ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="List of user's applications"
 *     ),
 *     security={{"ApiKey": {}}}
 * )
 */
Flight::route('GET /applications/user/@user_id', function ($user_id) use ($applicationService) {
    Flight::auth_middleware()->authorizeUserOrRole($user_id, [Roles::ADMIN]);
    Flight::json($applicationService->get_applications_by_user($user_id));
});

/**
 * @OA\Get(
 *     path="/applications/job/{job_id}",
 *     tags={"Applications"},
 *     summary="Get applications by job ID",
 *     @OA\Parameter(
 *         name="job_id",
 *         in="path",
 *         required=true,
 *         description="Job ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="List of applications for the job"
 *     ),
 *     security={{"ApiKey": {}}}
 * )
 */
Flight::route('GET /applications/job/@job_id', function ($job_id) use ($applicationService) {
    Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::EMPLOYER]);
    Flight::json($applicationService->get_applications_by_job($job_id));
});