<?php
require_once 'reservationDao.php';

// Create instance
$reservationDao = new ReservationDao();

// Test insert a new reservation (MAKE SURE user_id and studio_id exist)
$newReservation = [
    'user_id' => 1, // Replace with a valid user ID
    'category' => 'Recording', // or 'Rehearsal'
    'date' => '2025-04-08',
    'time' => '15:30:00',
    'include_sound_engineer' => 1, // 1 = true, 0 = false
    'studio_id' => 1 // Replace with a valid studio ID
];

// ✅ INSERT the reservation
/* $insertResult = $reservationDao->insert($newReservation);
echo "<h3>Insert Result:</h3><pre>";
echo $insertResult ? 'Insert successful' : 'Insert failed';
echo "</pre>";
 */
// ✅ FETCH all reservations
$reservations = $reservationDao->getAll();
echo "<h3>All Reservations:</h3><pre>";
print_r($reservations);
echo "</pre>";
?>
