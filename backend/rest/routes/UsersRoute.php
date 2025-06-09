<?php
require_once __DIR__ . '/../services/UsersService.class.php';
require_once __DIR__ . '/../../data/roles.class.php';


$userService = new UserService();
Flight::register('userService', 'UserService');

/**
 * @OA\Get(
 *     path="/users",
 *     tags={"Users"},
 *     summary="Get all users",
 *     @OA\Response(
 *         response=200,
 *         description="List of all users"
 *     ),
 *     security={{"ApiKey": {}}}
 * )
 */
Flight::route('GET /users', function () use ($userService) {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    Flight::json($userService->get_all_users());
});

/**
 * @OA\Get(
 *     path="/users/{id}",
 *     tags={"Users"},
 *     summary="Get user by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="User ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User found"
 *     ),
 *     security={{"ApiKey": {}}}
 * )
 */
Flight::route('GET /users/@id', function ($id) use ($userService) {
    Flight::auth_middleware()->authorizeUserOrRole($id, [Roles::ADMIN]);
    Flight::json($userService->get_user_by_id($id));
});

/**
 * @OA\Post(
 *     path="/users",
 *     tags={"Users"},
 *     summary="Create new user",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"email", "password", "first_name", "last_name", "role"},
 *             @OA\Property(property="email", type="string"),
 *             @OA\Property(property="password", type="string"),
 *             @OA\Property(property="first_name", type="string"),
 *             @OA\Property(property="last_name", type="string"),
 *             @OA\Property(property="role", type="string", enum={"user", "company", "admin"}),
 *             @OA\Property(property="company_id", type="integer"),
 *             @OA\Property(property="phone", type="string")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User created successfully"
 *     ),
 *     security={{"ApiKey": {}}}
 * )
 */
Flight::route('POST /users', function () use ($userService) {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    $data = Flight::request()->data->getData();
    Flight::json($userService->create_user($data));
});

/**
 * @OA\Put(
 *     path="/users/{id}",
 *     tags={"Users"},
 *     summary="Update user",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="User ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="first_name", type="string"),
 *             @OA\Property(property="last_name", type="string"),
 *             @OA\Property(property="phone", type="string"),
 *             @OA\Property(property="company_id", type="integer")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User updated successfully"
 *     ),
 *     security={{"ApiKey": {}}}
 * )
 */
Flight::route('PUT /users/@id', function ($id) use ($userService) {
    Flight::auth_middleware()->authorizeUserOrRole($id, [Roles::ADMIN]);
    try {
        $data = Flight::request()->data->getData();
        Flight::userService()->update($id, $data);
        Flight::json(["message" => "User updated successfully"]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(["error" => $e->getMessage()]);
        exit;
    }
});


/**
 * @OA\Delete(
 *     path="/users/{id}",
 *     tags={"Users"},
 *     summary="Delete user",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="User ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User deleted successfully"
 *     ),
 *     security={{"ApiKey": {}}}
 * )
 */
Flight::route('DELETE /users/@id', function ($id) use ($userService) {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    Flight::json($userService->delete_user($id));
});

/**
 * @OA\Get(
 *     path="/users/email/{email}",
 *     tags={"Users"},
 *     summary="Get user by email",
 *     @OA\Parameter(
 *         name="email",
 *         in="path",
 *         required=true,
 *         description="User email",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User found"
 *     ),
 *     security={{"ApiKey": {}}}
 * )
 */
Flight::route('GET /users/email/@email', function ($email) use ($userService) {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    Flight::json($userService->get_user_by_email($email));
});

/**
 * @OA\Get(
 *     path="/users/company/{company_id}",
 *     tags={"Users"},
 *     summary="Get users by company",
 *     @OA\Parameter(
 *         name="company_id",
 *         in="path",
 *         required=true,
 *         description="Company ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="List of company users"
 *     ),
 *     security={{"ApiKey": {}}}
 * )
 */
Flight::route('GET /users/company/@company_id', function ($company_id) use ($userService) {
    Flight::auth_middleware()->authorizeRoles([Roles::ADMIN,Roles::EMPLOYER]);
    Flight::json($userService->get_users_by_company($company_id));
});
