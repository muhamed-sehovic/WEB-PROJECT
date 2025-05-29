<?php
require_once __DIR__ . '/../services/UserService.php';
require_once __DIR__ . '/../data/roles.php';

Flight::register('userService', 'UserService');

/**
 * @OA\Get(
 *     path="/users",
 *     tags={"users"},
 *     summary="Get all users",
 *     @OA\Response(
 *         response=200,
 *         description="Array of all users"
 *     )
 * )
 */
Flight::route('GET /users', function() {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    Flight::json(Flight::userService()->getAllUsers());
});

/**
 * @OA\Get(
 *     path="/user/email",
 *     tags={"users"},
 *     summary="Get user by email",
 *     @OA\Parameter(
 *         name="email",
 *         in="query",
 *         required=true,
 *         description="User email",
 *         @OA\Schema(type="string", example="user@example.com")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User object by email"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Email query parameter is required"
 *     )
 * )
 */
Flight::route('GET /user/email', function() {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    $email = Flight::request()->query['email'];
    if (!$email) {
        Flight::halt(400, 'Email query parameter is required.');
    }
    Flight::json(Flight::userService()->getByEmail($email));
});

/**
 * @OA\Post(
 *     path="/register",
 *     tags={"users"},
 *     summary="Register a new user",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"email", "password"},
 *             @OA\Property(property="email", type="string", example="newuser@example.com"),
 *             @OA\Property(property="password", type="string", example="securePassword123"),
 *             @OA\Property(property="name", type="string", example="New User")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User registered successfully"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Email and password are required"
 *     )
 * )
 */
Flight::route('POST /register', function() {
    $data = Flight::request()->data->getData();
    if (!isset($data['email']) || !isset($data['password'])) {
        Flight::halt(400, 'Email and password are required.');
    }
    Flight::json(Flight::userService()->register($data));
});

/**
 * @OA\Post(
 *     path="/login",
 *     tags={"users"},
 *     summary="Log in a user",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"email", "password"},
 *             @OA\Property(property="email", type="string", example="user@example.com"),
 *             @OA\Property(property="password", type="string", example="securePassword123")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful login"
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Email and password are required"
 *     )
 * )
 */
Flight::route('POST /login', function() {
    $data = Flight::request()->data->getData();
    if (!isset($data['email']) || !isset($data['password'])) {
        Flight::halt(400, 'Email and password are required.');
    }
    Flight::json(Flight::userService()->login($data['email'], $data['password']));
});

/**
 * @OA\Put(
 *     path="/users/{id}",
 *     tags={"users"},
 *     summary="Update an existing user by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="User ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="email", type="string", example="updated@example.com"),
 *             @OA\Property(property="name", type="string", example="Updated Name"),
 *             @OA\Property(property="password", type="string", example="newPassword")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User updated successfully"
 *     )
 * )
 */
Flight::route('PUT /users/@id', function($id) {
    $user = Flight::auth_middleware()->authenticate();
    if ($user['role'] !== Roles::ADMIN && $user['id'] != $id) {
        Flight::halt(403, 'Permission denied.');
    }

    $data = Flight::request()->data->getData();
    Flight::json(Flight::userService()->update($id, $data));
});

/**
 * @OA\Delete(
 *     path="/users/{id}",
 *     tags={"users"},
 *     summary="Delete a user by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="User ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User deleted successfully"
 *     )
 * )
 */
Flight::route('DELETE /users/@id', function($id) {
    $user = Flight::auth_middleware()->authenticate();
    if ($user['role'] !== Roles::ADMIN && $user['id'] != $id) {
        Flight::halt(403, 'Permission denied.');
    }

    Flight::userService()->delete($id);
    Flight::json(['message' => 'User deleted']);
});
