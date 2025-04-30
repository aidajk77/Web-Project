<?php
require_once __DIR__ . '/../services/SavedJobsService.php';

$savedJobService = new SavedJobService();

/**
 * @OA\Get(
 *     path="/saved-jobs",
 *     tags={"Saved Jobs"},
 *     summary="Get all saved jobs",
 *     @OA\Response(
 *         response=200,
 *         description="List of all saved jobs"
 *     ),
 *     security={{"ApiKey": {}}}
 * )
 */
Flight::route('GET /saved-jobs', function () use ($savedJobService) {
    Flight::json($savedJobService->get_all_saved_jobs());
});

/**
 * @OA\Get(
 *     path="/saved-jobs/{id}",
 *     tags={"Saved Jobs"},
 *     summary="Get saved job by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Saved Job ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Saved job found"
 *     ),
 *     security={{"ApiKey": {}}}
 * )
 */
Flight::route('GET /saved-jobs/@id', function ($id) use ($savedJobService) {
    Flight::json($savedJobService->get_saved_job_by_id($id));
});

/**
 * @OA\Post(
 *     path="/saved-jobs",
 *     tags={"Saved Jobs"},
 *     summary="Save a new job",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"user_id", "job_id"},
 *             @OA\Property(property="user_id", type="integer"),
 *             @OA\Property(property="job_id", type="integer"),
 *             @OA\Property(property="notes", type="string")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Job saved successfully"
 *     ),
 *     security={{"ApiKey": {}}}
 * )
 */
Flight::route('POST /saved-jobs', function () use ($savedJobService) {
    $data = Flight::request()->data->getData();
    Flight::json($savedJobService->create_saved_job($data));
});

/**
 * @OA\Put(
 *     path="/saved-jobs/{id}",
 *     tags={"Saved Jobs"},
 *     summary="Update saved job",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Saved Job ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="notes", type="string")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Saved job updated successfully"
 *     ),
 *     security={{"ApiKey": {}}}
 * )
 */
Flight::route('PUT /saved-jobs/@id', function ($id) use ($savedJobService) {
    $data = Flight::request()->data->getData();
    Flight::json($savedJobService->update_saved_job($id, $data));
});

/**
 * @OA\Delete(
 *     path="/saved-jobs/{id}",
 *     tags={"Saved Jobs"},
 *     summary="Delete saved job",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Saved Job ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Saved job deleted successfully"
 *     ),
 *     security={{"ApiKey": {}}}
 * )
 */
Flight::route('DELETE /saved-jobs/@id', function ($id) use ($savedJobService) {
    Flight::json($savedJobService->delete_saved_job($id));
});

/**
 * @OA\Get(
 *     path="/saved-jobs/user/{user_id}",
 *     tags={"Saved Jobs"},
 *     summary="Get saved jobs by user",
 *     @OA\Parameter(
 *         name="user_id",
 *         in="path",
 *         required=true,
 *         description="User ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="List of user's saved jobs"
 *     ),
 *     security={{"ApiKey": {}}}
 * )
 */
Flight::route('GET /saved-jobs/user/@user_id', function ($user_id) use ($savedJobService) {
    Flight::json($savedJobService->get_saved_jobs_by_user($user_id));
});

/**
 * @OA\Get(
 *     path="/saved-jobs/job/{job_id}",
 *     tags={"Saved Jobs"},
 *     summary="Get users who saved a job",
 *     @OA\Parameter(
 *         name="job_id",
 *         in="path",
 *         required=true,
 *         description="Job ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="List of users who saved this job"
 *     ),
 *     security={{"ApiKey": {}}}
 * )
 */
Flight::route('GET /saved-jobs/job/@job_id', function ($job_id) use ($savedJobService) {
    Flight::json($savedJobService->get_users_who_saved_job($job_id));
});