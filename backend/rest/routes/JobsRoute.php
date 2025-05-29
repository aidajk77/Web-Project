<?php
require_once __DIR__ . '/../services/JobsService.class.php';

$jobService = new JobService();

/**
 * @OA\Get(
 *     path="/jobs",
 *     tags={"Jobs"},
 *     summary="Get all jobs",
 *     @OA\Response(
 *         response=200,
 *         description="List of all jobs"
 *     ),
 *     security={{"ApiKey": {}}}
 * )
 */
Flight::route('GET /jobs', function () use ($jobService) {
    $page = Flight::request()->query['page'] ?? null;
    $limit = Flight::request()->query['limit'] ?? null;

    if ($page && $limit) {
        $data = $jobService->get_jobs_paginated((int)$page, (int)$limit);
        Flight::json($data);
    } else {
        Flight::json($jobService->get_all_jobs());

    }
});


/**
 * @OA\Get(
 *     path="/jobs/{id}",
 *     tags={"Jobs"},
 *     summary="Get job by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Job ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Job found"
 *     ),
 *     security={{"ApiKey": {}}}
 * )
 */
Flight::route('GET /jobs/@id', function ($id) use ($jobService) {
    Flight::json($jobService->get_job_by_id($id));
});

/**
 * @OA\Post(
 *     path="/jobs",
 *     tags={"Jobs"},
 *     summary="Create new job",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"title", "description", "company_id", "location", "salary"},
 *             @OA\Property(property="title", type="string"),
 *             @OA\Property(property="description", type="string"),
 *             @OA\Property(property="company_id", type="integer"),
 *             @OA\Property(property="location", type="string"),
 *             @OA\Property(property="salary", type="number"),
 *             @OA\Property(property="requirements", type="string"),
 *             @OA\Property(property="status", type="string", enum={"open", "closed"})
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Job created successfully"
 *     ),
 *     security={{"ApiKey": {}}}
 * )
 */
Flight::route('POST /jobs', function () use ($jobService) {
    Flight::auth_middleware()->authorizeRoles([Roles::EMPLOYER, Roles::ADMIN]);
    $data = Flight::request()->data->getData();
    Flight::json($jobService->create_job($data));
});
/**
 * @OA\Put(
 *     path="/jobs/{id}",
 *     tags={"Jobs"},
 *     summary="Update job",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Job ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="title", type="string"),
 *             @OA\Property(property="description", type="string"),
 *             @OA\Property(property="location", type="string"),
 *             @OA\Property(property="salary", type="number"),
 *             @OA\Property(property="requirements", type="string"),
 *             @OA\Property(property="status", type="string", enum={"open", "closed"})
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Job updated successfully"
 *     ),
 *     security={{"ApiKey": {}}}
 * )
 */
Flight::route('PUT /jobs/@id', function ($id) use ($jobService) {
    Flight::auth_middleware()->authorizeRoles([Roles::EMPLOYER, Roles::ADMIN]);
    $data = Flight::request()->data->getData();
    Flight::json($jobService->update_job($id, $data));
});

/**
 * @OA\Delete(
 *     path="/jobs/{id}",
 *     tags={"Jobs"},
 *     summary="Delete job",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Job ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Job deleted successfully"
 *     ),
 *     security={{"ApiKey": {}}}
 * )
 */
Flight::route('DELETE /jobs/@id', function ($id) use ($jobService) {
    Flight::auth_middleware()->authorizeRoles([Roles::EMPLOYER, Roles::ADMIN]);
    Flight::json($jobService->delete_job($id));
});

/**
 * @OA\Get(
 *     path="/jobs/search/title/{title}",
 *     tags={"Jobs"},
 *     summary="Search jobs by title",
 *     @OA\Parameter(
 *         name="title",
 *         in="path",
 *         required=true,
 *         description="Job title to search for",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Jobs matching the search"
 *     ),
 *     security={{"ApiKey": {}}}
 * )
 */
Flight::route('GET /jobs/search/title/@title', function ($title) use ($jobService) {
    Flight::json($jobService->search_job_by_title($title));
});

/**
 * @OA\Get(
 *     path="/jobs/company/{company_id}",
 *     tags={"Jobs"},
 *     summary="Get jobs by company",
 *     @OA\Parameter(
 *         name="company_id",
 *         in="path",
 *         required=true,
 *         description="Company ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="List of company's jobs"
 *     ),
 *     security={{"ApiKey": {}}}
 * )
 */
Flight::route('GET /jobs/company/@company_id', function ($company_id) use ($jobService) {
    Flight::auth_middleware()->authorizeRoles([Roles::EMPLOYER, Roles::ADMIN]);
    Flight::json($jobService->get_jobs_by_company($company_id));
});

/**
 * @OA\Get(
 *     path="/jobs/location",
 *     tags={"Jobs"},
 *     summary="Filter jobs by location with pagination",
 *     @OA\Parameter(
 *         name="offset",
 *         in="query",
 *         required=false,
 *         description="Number of records to skip",
 *         @OA\Schema(type="integer", default=0)
 *     ),
 *     @OA\Parameter(
 *         name="limit",
 *         in="query",
 *         required=false,
 *         description="Number of records to return",
 *         @OA\Schema(type="integer", default=10)
 *     ),
 *     @OA\Parameter(
 *         name="location",
 *         in="query",
 *         required=false,
 *         description="Location to filter by",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Filtered list of jobs"
 *     ),
 *     security={{"ApiKey": {}}}
 * )
 */
Flight::route('GET /jobs/location', function () use ($jobService) {
    $offset = (int) Flight::request()->query['offset'] ?? 0;
    $limit = (int) Flight::request()->query['limit'] ?? 10;
    $location = Flight::request()->query['location'] ?? null;

    Flight::json($jobService->filter_jobs_by_location_paginated($offset, $limit, $location));
});


