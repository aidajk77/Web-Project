<?php
require_once __DIR__ . '/../services/JobCategoriesService.class.php';

$jobCategoryService = new JobCategoryService();

/**
 * @OA\Get(
 *     path="/job-categories",
 *     tags={"Job Categories"},
 *     summary="Get all job categories",
 *     @OA\Response(
 *         response=200,
 *         description="List of all job categories"
 *     ),
 *     security={{"ApiKey": {}}}
 * )
 */
Flight::route('GET /job-categories', function () use ($jobCategoryService) {
    Flight::json($jobCategoryService->get_all_categories());
});

/**
 * @OA\Get(
 *     path="/job-categories/{id}",
 *     tags={"Job Categories"},
 *     summary="Get job category by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Category ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Category found"
 *     ),
 *     security={{"ApiKey": {}}}
 * )
 */
Flight::route('GET /job-categories/@id', function ($id) use ($jobCategoryService) {
    Flight::json($jobCategoryService->get_category_by_id($id));
});

/**
 * @OA\Post(
 *     path="/job-categories",
 *     tags={"Job Categories"},
 *     summary="Create new job category",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name", "description"},
 *             @OA\Property(property="name", type="string"),
 *             @OA\Property(property="description", type="string")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Category created successfully"
 *     ),
 *     security={{"ApiKey": {}}}
 * )
 */
Flight::route('POST /job-categories', function () use ($jobCategoryService) {
    $data = Flight::request()->data->getData();
    Flight::json($jobCategoryService->create_category($data));
});

/**
 * @OA\Put(
 *     path="/job-categories/{id}",
 *     tags={"Job Categories"},
 *     summary="Update job category",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Category ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="name", type="string"),
 *             @OA\Property(property="description", type="string")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Category updated successfully"
 *     ),
 *     security={{"ApiKey": {}}}
 * )
 */
Flight::route('PUT /job-categories/@id', function ($id) use ($jobCategoryService) {
    $data = Flight::request()->data->getData();
    Flight::json($jobCategoryService->update_category($id, $data));
});

/**
 * @OA\Delete(
 *     path="/job-categories/{id}",
 *     tags={"Job Categories"},
 *     summary="Delete job category",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Category ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Category deleted successfully"
 *     ),
 *     security={{"ApiKey": {}}}
 * )
 */
Flight::route('DELETE /job-categories/@id', function ($id) use ($jobCategoryService) {
    Flight::json($jobCategoryService->delete_category($id));
});
