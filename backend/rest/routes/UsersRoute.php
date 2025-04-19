<?php
require_once __DIR__ . '/../services/UsersService.php';

$userService = new UserService();

// GET /users
Flight::route('GET /users', function () use ($userService) {
    Flight::json($userService->get_all_users());
});

// GET /users/@id
Flight::route('GET /users/@id', function ($id) use ($userService) {
    Flight::json($userService->get_user_by_id($id));
});

// POST /users
Flight::route('POST /users', function () use ($userService) {
    $data = Flight::request()->data->getData();
    Flight::json($userService->create_user($data));
});

// PUT /users/@id
Flight::route('PUT /users/@id', function ($id) use ($userService) {
    $data = Flight::request()->data->getData();
    Flight::json($userService->update_user($id, $data));
});

// DELETE /users/@id
Flight::route('DELETE /users/@id', function ($id) use ($userService) {
    Flight::json($userService->delete_user($id));
});

// GET /users/email/@email
Flight::route('GET /users/email/@email', function ($email) use ($userService) {
    Flight::json($userService->get_user_by_email($email));
});

// GET /users/company/@company_id
Flight::route('GET /users/company/@company_id', function ($company_id) use ($userService) {
    Flight::json($userService->get_users_by_company($company_id));
});
