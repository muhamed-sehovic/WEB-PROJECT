<?php
require_once __DIR__ . '/../services/ReservationService.php';
require_once __DIR__ . '/../data/roles.php';

Flight::register('reservationService', 'ReservationService');

/**
 * @OA\Get(
 *     path="/reservations",
 *     tags={"reservations"},
 *     summary="Get all reservations",
 *     @OA\Response(
 *         response=200,
 *         description="Array of all reservations"
 *     )
 * )
 */
Flight::route('GET /reservations', function() {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    Flight::json(Flight::reservationService()->getAll());
});

/**
 * @OA\Get(
 *     path="/reservations/{id}",
 *     tags={"reservations"},
 *     summary="Get reservation by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Reservation ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Reservation with the specified ID"
 *     )
 * )
 */
Flight::route('GET /reservations/@id', function($id) {
    Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
    Flight::json(Flight::reservationService()->getById($id));
});

/**
 * @OA\Post(
 *     path="/reservations",
 *     tags={"reservations"},
 *     summary="Create a new reservation",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"user_id", "studio_id", "start_time", "end_time"},
 *             @OA\Property(property="user_id", type="integer", example=1),
 *             @OA\Property(property="studio_id", type="integer", example=2),
 *             @OA\Property(property="start_time", type="string", format="date-time", example="2025-05-05T10:00:00"),
 *             @OA\Property(property="end_time", type="string", format="date-time", example="2025-05-05T12:00:00"),
 *             @OA\Property(property="notes", type="string", example="Bring own microphone")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="New reservation created"
 *     )
 * )
 */
Flight::route('POST /reservations', function() {
    Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
    $data = Flight::request()->data->getData();
    Flight::json(Flight::reservationService()->add($data));
});

/**
 * @OA\Put(
 *     path="/reservations/{id}",
 *     tags={"reservations"},
 *     summary="Update an existing reservation",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Reservation ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="user_id", type="integer", example=1),
 *             @OA\Property(property="studio_id", type="integer", example=2),
 *             @OA\Property(property="start_time", type="string", format="date-time", example="2025-05-05T14:00:00"),
 *             @OA\Property(property="end_time", type="string", format="date-time", example="2025-05-05T16:00:00"),
 *             @OA\Property(property="notes", type="string", example="Changed timing")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Reservation updated"
 *     )
 * )
 */
Flight::route('PUT /reservations/@id', function($id) {
    Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
    $data = Flight::request()->data->getData();
    Flight::json(Flight::reservationService()->update($id, $data));
});

/**
 * @OA\Delete(
 *     path="/reservations/{id}",
 *     tags={"reservations"},
 *     summary="Delete a reservation",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Reservation ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Reservation deleted"
 *     )
 * )
 */
Flight::route('DELETE /reservations/@id', function($id) {
    Flight::auth_middleware()->authorizeRoles([Roles::ADMIN, Roles::USER]);
    Flight::reservationService()->delete($id);
    Flight::json(['message' => 'Reservation deleted']);
});
