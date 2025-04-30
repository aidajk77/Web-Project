<?php
require_once __DIR__ . '/../services/JobCategoryMappingService.php';

$mappingService = new JobCategoryMappingService();

/**
 * @OA\Get(
 *     path="/job-category-mappings/job/{job_id}",
 *     tags={"Job Category Mappings"},
 *     summary="Get categories for a job",
 *     @OA\Parameter(
 *         name="job_id",
 *         in="path",
 *         required=true,
 *         description="Job ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="List of categories for the job"
 *     ),
 *     security={{"ApiKey": {}}}
 * )
 */
Flight::route('GET /job-category-mappings/job/@job_id', function ($job_id) use ($mappingService) {
    Flight::json($mappingService->get_categories_by_job($job_id));
});

/**
 * @OA\Get(
 *     path="/job-category-mappings/category/{category_id}",
 *     tags={"Job Category Mappings"},
 *     summary="Get jobs for a category",
 *     @OA\Parameter(
 *         name="category_id",
 *         in="path",
 *         required=true,
 *         description="Category ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="List of jobs in the category"
 *     ),
 *     security={{"ApiKey": {}}}
 * )
 */
Flight::route('GET /job-category-mappings/category/@category_id', function ($category_id) use ($mappingService) {
    Flight::json($mappingService->get_jobs_by_category($category_id));
});

/**
 * @OA\Post(
 *     path="/job-category-mappings",
 *     tags={"Job Category Mappings"},
 *     summary="Create new job-category mapping",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"job_id", "category_id"},
 *             @OA\Property(property="job_id", type="integer"),
 *             @OA\Property(property="category_id", type="integer")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Mapping created successfully"
 *     ),
 *     security={{"ApiKey": {}}}
 * )
 */
Flight::route('POST /job-category-mappings', function () use ($mappingService) {
    $data = Flight::request()->data->getData();
    Flight::json($mappingService->create_mapping($data));
});

/**
 * @OA\Put(
 *     path="/job-category-mappings/{id}",
 *     tags={"Job Category Mappings"},
 *     summary="Update job-category mapping",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Mapping ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="job_id", type="integer"),
 *             @OA\Property(property="category_id", type="integer")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Mapping updated successfully"
 *     ),
 *     security={{"ApiKey": {}}}
 * )
 */
Flight::route('PUT /job-category-mappings/@id', function ($id) use ($mappingService) {
    $data = Flight::request()->data->getData();
    Flight::json($mappingService->update_mapping($id, $data));
});

/**
 * @OA\Delete(
 *     path="/job-category-mappings/{id}",
 *     tags={"Job Category Mappings"},
 *     summary="Delete job-category mapping",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Mapping ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Mapping deleted successfully"
 *     ),
 *     security={{"ApiKey": {}}}
 * )
 */
Flight::route('DELETE /job-category-mappings/@id', function ($id) use ($mappingService) {
    Flight::json($mappingService->delete_mapping($id));
});
