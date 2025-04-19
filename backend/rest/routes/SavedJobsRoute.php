<?php
require_once __DIR__ . '/../services/SavedJobsService.php';

$savedJobService = new SavedJobService();

// GET /saved-jobs
Flight::route('GET /saved-jobs', function () use ($savedJobService) {
    Flight::json($savedJobService->get_all_saved_jobs());
});

// GET /saved-jobs/@id
Flight::route('GET /saved-jobs/@id', function ($id) use ($savedJobService) {
    Flight::json($savedJobService->get_saved_job_by_id($id));
});

// POST /saved-jobs
Flight::route('POST /saved-jobs', function () use ($savedJobService) {
    $data = Flight::request()->data->getData();
    Flight::json($savedJobService->create_saved_job($data));
});

// PUT /saved-jobs/@id
Flight::route('PUT /saved-jobs/@id', function ($id) use ($savedJobService) {
    $data = Flight::request()->data->getData();
    Flight::json($savedJobService->update_saved_job($id, $data));
});

// DELETE /saved-jobs/@id
Flight::route('DELETE /saved-jobs/@id', function ($id) use ($savedJobService) {
    Flight::json($savedJobService->delete_saved_job($id));
});

// GET /saved-jobs/user/@user_id
Flight::route('GET /saved-jobs/user/@user_id', function ($user_id) use ($savedJobService) {
    Flight::json($savedJobService->get_saved_jobs_by_user($user_id));
});

// GET /saved-jobs/job/@job_id
Flight::route('GET /saved-jobs/job/@job_id', function ($job_id) use ($savedJobService) {
    Flight::json($savedJobService->get_users_who_saved_job($job_id));
});
