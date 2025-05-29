<?php
require_once __DIR__ . '/../services/EquipmentService.php';
require_once __DIR__ . '/../data/roles.php';

Flight::register('equipmentService', 'EquipmentService');

/**
 * @OA\Get(
 *     path="/equipment",
 *     tags={"equipment"},
 *     summary="Get all equipment",
 *     @OA\Response(
 *         response=200,
 *         description="Array of all equipment"
 *     )
 * )
 */
Flight::route('GET /equipment', function() {
    Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
    Flight::json(Flight::equipmentService()->getAll());
});

/**
 * @OA\Get(
 *     path="/equipment/{id}",
 *     tags={"equipment"},
 *     summary="Get equipment by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Equipment ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Returns the equipment with the given ID"
 *     )
 * )
 */
Flight::route('GET /equipment/@id', function($id) {
    Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
    Flight::json(Flight::equipmentService()->getById($id));
});

/**
 * @OA\Post(
 *     path="/equipment",
 *     tags={"equipment"},
 *     summary="Add new equipment",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name", "type"},
 *             @OA\Property(property="name", type="string", example="Microphone"),
 *             @OA\Property(property="type", type="string", example="Audio"),
 *             @OA\Property(property="status", type="string", example="available")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="New equipment added"
 *     )
 * )
 */
Flight::route('POST /equipment', function() {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    $data = Flight::request()->data->getData();
    Flight::json(Flight::equipmentService()->add($data));
});

/**
 * @OA\Put(
 *     path="/equipment/{id}",
 *     tags={"equipment"},
 *     summary="Update existing equipment",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Equipment ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name", "type"},
 *             @OA\Property(property="name", type="string", example="Updated Microphone"),
 *             @OA\Property(property="type", type="string", example="Audio"),
 *             @OA\Property(property="status", type="string", example="in_use")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Equipment updated"
 *     )
 * )
 */
Flight::route('PUT /equipment/@id', function($id) {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    $data = Flight::request()->data->getData();
    Flight::json(Flight::equipmentService()->update($id, $data));
});

/**
 * @OA\Delete(
 *     path="/equipment/{id}",
 *     tags={"equipment"},
 *     summary="Delete equipment",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Equipment ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Equipment deleted"
 *     )
 * )
 */
Flight::route('DELETE /equipment/@id', function($id) {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    Flight::equipmentService()->delete($id);
    Flight::json(['message' => 'Equipment deleted']);
});
