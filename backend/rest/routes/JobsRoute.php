<?php
require_once __DIR__ . '/../services/JobsService.php';

$jobService = new JobService();

// GET /jobs
Flight::route('GET /jobs', function () use ($jobService) {
    Flight::json($jobService->get_all_jobs());
});

// GET /jobs/@id
Flight::route('GET /jobs/@id', function ($id) use ($jobService) {
    Flight::json($jobService->get_job_by_id($id));
});

// POST /jobs
Flight::route('POST /jobs', function () use ($jobService) {
    $data = Flight::request()->data->getData();
    Flight::json($jobService->create_job($data));
});

// PUT /jobs/@id
Flight::route('PUT /jobs/@id', function ($id) use ($jobService) {
    $data = Flight::request()->data->getData();
    Flight::json($jobService->update_job($id, $data));
});

// DELETE /jobs/@id
Flight::route('DELETE /jobs/@id', function ($id) use ($jobService) {
    Flight::json($jobService->delete_job($id));
});

// GET /jobs/search/title/@title
Flight::route('GET /jobs/search/title/@title', function ($title) use ($jobService) {
    Flight::json($jobService->search_job_by_title($title));
});

// GET /jobs/company/@company_id
Flight::route('GET /jobs/company/@company_id', function ($company_id) use ($jobService) {
    Flight::json($jobService->get_jobs_by_company($company_id));
});

// GET /jobs/location?offset=0&limit=10&location=NYC
Flight::route('GET /jobs/location', function () use ($jobService) {
    $offset = (int) Flight::request()->query['offset'] ?? 0;
    $limit = (int) Flight::request()->query['limit'] ?? 10;
    $location = Flight::request()->query['location'] ?? null;

    Flight::json($jobService->filter_jobs_by_location_paginated($offset, $limit, $location));
});
