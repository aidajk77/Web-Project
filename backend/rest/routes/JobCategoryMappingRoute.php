<?php
require_once __DIR__ . '/../services/JobCategoryMappingService.php';

$mappingService = new JobCategoryMappingService();

// GET /job-category-mappings/job/@job_id
Flight::route('GET /job-category-mappings/job/@job_id', function ($job_id) use ($mappingService) {
    Flight::json($mappingService->get_categories_by_job($job_id));
});

// GET /job-category-mappings/category/@category_id
Flight::route('GET /job-category-mappings/category/@category_id', function ($category_id) use ($mappingService) {
    Flight::json($mappingService->get_jobs_by_category($category_id));
});

// POST /job-category-mappings
Flight::route('POST /job-category-mappings', function () use ($mappingService) {
    $data = Flight::request()->data->getData();
    Flight::json($mappingService->create_mapping($data));
});

// PUT /job-category-mappings/@id
Flight::route('PUT /job-category-mappings/@id', function ($id) use ($mappingService) {
    $data = Flight::request()->data->getData();
    Flight::json($mappingService->update_mapping($id, $data));
});

// DELETE /job-category-mappings/@id
Flight::route('DELETE /job-category-mappings/@id', function ($id) use ($mappingService) {
    Flight::json($mappingService->delete_mapping($id));
});
