<?php
require_once __DIR__ . '/../services/ApplicationsService.class.php';

$applicationService = new ApplicationService();

// GET /applications
Flight::route('GET /applications', function () use ($applicationService) {
    Flight::json($applicationService->get_all_applications());
});

// GET /applications/@id
Flight::route('GET /applications/@id', function ($id) use ($applicationService) {
    Flight::json($applicationService->get_application_by_id($id));
});

// POST /applications
Flight::route('POST /applications', function () use ($applicationService) {
    $data = Flight::request()->data->getData();
    // Optionally: validate $data here before passing
    Flight::json($applicationService->create_application($data));
});

// PUT /applications/@id
Flight::route('PUT /applications/@id', function ($id) use ($applicationService) {
    $data = Flight::request()->data->getData();
    Flight::json($applicationService->update_application($id, $data));
});

// DELETE /applications/@id
Flight::route('DELETE /applications/@id', function ($id) use ($applicationService) {
    Flight::json($applicationService->delete_application($id));
});

// GET /applications/user/@user_id
Flight::route('GET /applications/user/@user_id', function ($user_id) use ($applicationService) {
    Flight::json($applicationService->get_applications_by_user($user_id));
});

// GET /applications/job/@job_id
Flight::route('GET /applications/job/@job_id', function ($job_id) use ($applicationService) {
    Flight::json($applicationService->get_applications_by_job($job_id));
});
