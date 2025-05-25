<?php
require_once __DIR__ . '/../services/StudioService.php';
require_once __DIR__ . '/../data/roles.php';

Flight::register('studioService', 'StudioService');

/**
 * @OA\Get(
 *     path="/studios",
 *     tags={"studios"},
 *     summary="Get all studios",
 *     @OA\Response(
 *         response=200,
 *         description="Array of all studios"
 *     )
 * )
 */
Flight::route('GET /studios', function() {
    Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
    Flight::json(Flight::studioService()->getAll());
});

/**
 * @OA\Get(
 *     path="/studios/{id}",
 *     tags={"studios"},
 *     summary="Get a studio by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Studio ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Returns the studio with the given ID"
 *     )
 * )
 */
Flight::route('GET /studios/@id', function($id) {
    Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
    Flight::json(Flight::studioService()->getById($id));
});

/**
 * @OA\Post(
 *     path="/studios",
 *     tags={"studios"},
 *     summary="Add a new studio",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name", "location"},
 *             @OA\Property(property="name", type="string", example="Studio Alpha"),
 *             @OA\Property(property="location", type="string", example="New York"),
 *             @OA\Property(property="description", type="string", example="Spacious studio for recording"),
 *             @OA\Property(property="capacity", type="integer", example=50)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="New studio created"
 *     )
 * )
 */
Flight::route('POST /studios', function() {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    $data = Flight::request()->data->getData();
    Flight::json(Flight::studioService()->add($data));
});

/**
 * @OA\Put(
 *     path="/studios/{id}",
 *     tags={"studios"},
 *     summary="Update a studio by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Studio ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="name", type="string", example="Updated Studio"),
 *             @OA\Property(property="location", type="string", example="Los Angeles"),
 *             @OA\Property(property="description", type="string", example="Updated description"),
 *             @OA\Property(property="capacity", type="integer", example=75)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Studio updated"
 *     )
 * )
 */
Flight::route('PUT /studios/@id', function($id) {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    $data = Flight::request()->data->getData();
    Flight::json(Flight::studioService()->update($id, $data));
});

/**
 * @OA\Delete(
 *     path="/studios/{id}",
 *     tags={"studios"},
 *     summary="Delete a studio by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Studio ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Studio deleted"
 *     )
 * )
 */
Flight::route('DELETE /studios/@id', function($id) {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    Flight::studioService()->delete($id);
    Flight::json(['message' => 'Studio deleted']);
});
