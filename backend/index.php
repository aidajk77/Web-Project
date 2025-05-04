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

Flight::route('/', function() {
    echo 'root ok';
});

Flight::register('applicationsService', 'ApplicationsService');
Flight::register('companiesService', 'CompaniesService');
Flight::register('jobCategoriesService', 'JobCategoriesService');
Flight::register('jobCategoryMapping', 'JobCategoryMappingService');
Flight::register('jobsService', 'JobsService');
Flight::register('savedJobs', 'SavedJobsService');
Flight::register('usersService', 'UsersService');

Flight::route('/ping', function(){
    echo 'pong';
});

// Load routes
require_once __DIR__ . '/../backend/rest/routes/ApplicationsRoute.php';
require_once __DIR__ . '/../backend/rest/routes/CompaniesRoute.php';
require_once __DIR__ . '/../backend/rest/routes/JobCategoryRoute.php';
require_once __DIR__ . '/../backend/rest/routes/JobCategoryMappingRoute.php';
require_once __DIR__ . '/../backend/rest/routes/JobsRoute.php';
require_once __DIR__ . '/../backend/rest/routes/SavedJobsRoute.php';
require_once __DIR__ . '/../backend/rest/routes/UsersRoute.php';

// Start FlightPHP
Flight::start();
