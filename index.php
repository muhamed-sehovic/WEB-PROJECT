<?php
require 'vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// Enable error reporting for development
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Register services
require_once __DIR__ . '/Backend/services/AuthService.php';
require_once __DIR__ . '/Backend/services/UserService.php';
require_once __DIR__ . '/Backend/services/StudioService.php';
require_once __DIR__ . '/Backend/services/EquipmentService.php';
require_once __DIR__ . '/Backend/services/ReservationService.php';
require_once __DIR__ . '/Backend/services/ReviewService.php';

// Register middleware
require_once __DIR__ . '/Backend/middleware/AuthMiddleware.php';

// Service bindings
Flight::register('auth_service', 'AuthService');
Flight::register('userService', 'UserService');
Flight::register('studioService', 'StudioService');
Flight::register('equipmentService', 'EquipmentService');
Flight::register('reservationService', 'ReservationService');
Flight::register('reviewService', 'ReviewService');
Flight::register('auth_middleware', 'AuthMiddleware');

// Apply JWT token verification globally
Flight::route('/*', function () {
    $path = Flight::request()->url;

    if (
        strpos($path, '/auth/login') === 0 ||
        strpos($path, '/auth/register') === 0
    ) {
        return true; // Public endpoints
    }

    try {
        $token = Flight::request()->getHeader("Authentication");

        if (Flight::auth_middleware()->verifyToken($token)) {
            return true;
        }
    } catch (Exception $e) {
        Flight::halt(401, $e->getMessage());
    }
});

// Routes
require_once __DIR__ . '/Backend/routes/AuthRoutes.php';
require_once __DIR__ . '/Backend/routes/userRoutes.php';
require_once __DIR__ . '/Backend/routes/studioRoutes.php';
require_once __DIR__ . '/Backend/routes/equipmentRoutes.php';
require_once __DIR__ . '/Backend/routes/reservationRoutes.php';
require_once __DIR__ . '/Backend/routes/reviewRoutes.php';

// Default route
Flight::route('/', function () {
    echo '🎵 Welcome to the Music Studio API!';
});

// Start FlightPHP
Flight::start();
