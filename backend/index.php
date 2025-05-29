<?php
require_once __DIR__ . '/vendor/autoload.php';


// Register services
require_once __DIR__ . '/../backend/rest/services/BaseService.class.php';
require_once __DIR__ . '/../backend/rest/services/ApplicationsService.class.php';
require_once __DIR__ . '/../backend/rest/services/CompaniesService.class.php';
require_once __DIR__ . '/../backend/rest/services/JobCategoriesService.class.php';
require_once __DIR__ . '/../backend/rest/services/JobCategoryMappingService.class.php';
require_once __DIR__ . '/../backend/rest/services/JobsService.class.php';
require_once __DIR__ . '/../backend/rest/services/SavedJobsService.class.php';
require_once __DIR__ . '/../backend/rest/services/UsersService.class.php';
require_once __DIR__ . '/../backend/rest/services/AuthService.class.php';
require_once __DIR__ . '/../backend/middleware/AuthMiddleware.class.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;


Flight::register('applicationsService', 'ApplicationsService');
Flight::register('companiesService', 'CompaniesService');
Flight::register('jobCategoriesService', 'JobCategoriesService');
Flight::register('jobCategoryMapping', 'JobCategoryMappingService');
Flight::register('jobsService', 'JobsService');
Flight::register('savedJobs', 'SavedJobsService');
Flight::register('usersService', 'UsersService');
Flight::register('auth_service', "AuthService");

// ✅ Map the auth middleware properly
Flight::map('auth_middleware', function() {
    return new AuthMiddleware();
});
// This wildcard route intercepts all requests and applies authentication checks before proceeding.
Flight::route('/*', function() {
    if(
        str_contains(Flight::request()->url, '/auth/login') ||
        str_contains(Flight::request()->url, '/auth/register') ||
        str_contains(Flight::request()->url, '/jobs')

    ) {
        return TRUE;
    } else {
        try {

            $token = Flight::request()->getHeader("Authentication");

            
            if(Flight::auth_middleware()->verifyToken($token))
                return TRUE;
        } catch (\Exception $e) {
            Flight::halt(401, $e->getMessage());
        }
    }
});


// Load routes
require_once __DIR__ . '/../backend/rest/routes/ApplicationsRoute.php';
require_once __DIR__ . '/../backend/rest/routes/CompaniesRoute.php';
require_once __DIR__ . '/../backend/rest/routes/JobCategoryRoute.php';
require_once __DIR__ . '/../backend/rest/routes/JobCategoryMappingRoute.php';
require_once __DIR__ . '/../backend/rest/routes/JobsRoute.php';
require_once __DIR__ . '/../backend/rest/routes/SavedJobsRoute.php';
require_once __DIR__ . '/../backend/rest/routes/UsersRoute.php';
require_once __DIR__ . '/../backend/rest/routes/AuthRoute.php';

// Start FlightPHP
Flight::start();
