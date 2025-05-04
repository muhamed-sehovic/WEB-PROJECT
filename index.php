<?php
// Enable error reporting for development
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Autoload vendor packages (e.g., FlightPHP)
require_once __DIR__ . '/vendor/autoload.php';

// Register services (optional but recommended for reuse in closures)
require_once __DIR__ . '/Backend/services/UserService.php';
require_once __DIR__ . '/Backend/services/StudioService.php';
require_once __DIR__ . '/Backend/services/EquipmentService.php';
require_once __DIR__ . '/Backend/services/ReservationService.php';
require_once __DIR__ . '/Backend/services/ReviewService.php';

// Load routes
require_once __DIR__ . '/Backend/routes/userRoutes.php';
require_once __DIR__ . '/Backend/routes/studioRoutes.php';
require_once __DIR__ . '/Backend/routes/equipmentRoutes.php';
require_once __DIR__ . '/Backend/routes/reservationRoutes.php';
require_once __DIR__ . '/Backend/routes/reviewRoutes.php';

// Default route
Flight::route('/', function(){
    echo '🎵 Welcome to the Music Studio API!';
});


// Start FlightPHP
Flight::start();
