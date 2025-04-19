<?php
require_once __DIR__ . '/../services/JobCategoryService.php';

$jobCategoryService = new JobCategoryService();

// GET /job-categories
Flight::route('GET /job-categories', function () use ($jobCategoryService) {
    Flight::json($jobCategoryService->get_all_categories());
});

// GET /job-categories/@id
Flight::route('GET /job-categories/@id', function ($id) use ($jobCategoryService) {
    Flight::json($jobCategoryService->get_category_by_id($id));
});

// POST /job-categories
Flight::route('POST /job-categories', function () use ($jobCategoryService) {
    $data = Flight::request()->data->getData();
    Flight::json($jobCategoryService->create_category($data));
});

// PUT /job-categories/@id
Flight::route('PUT /job-categories/@id', function ($id) use ($jobCategoryService) {
    $data = Flight::request()->data->getData();
    Flight::json($jobCategoryService->update_category($id, $data));
});

// DELETE /job-categories/@id
Flight::route('DELETE /job-categories/@id', function ($id) use ($jobCategoryService) {
    Flight::json($jobCategoryService->delete_category($id));
});
