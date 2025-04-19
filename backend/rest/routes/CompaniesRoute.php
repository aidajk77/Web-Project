<?php
require_once __DIR__ . '/../services/CompaniesService.php';

$companyService = new CompanyService();

// GET /companies
Flight::route('GET /companies', function () use ($companyService) {
    Flight::json($companyService->get_all_companies());
});

// GET /companies/@id
Flight::route('GET /companies/@id', function ($id) use ($companyService) {
    Flight::json($companyService->get_company_by_id($id));
});

// POST /companies
Flight::route('POST /companies', function () use ($companyService) {
    $data = Flight::request()->data->getData();
    Flight::json($companyService->create_company($data));
});

// PUT /companies/@id
Flight::route('PUT /companies/@id', function ($id) use ($companyService) {
    $data = Flight::request()->data->getData();
    Flight::json($companyService->update_company($id, $data));
});

// DELETE /companies/@id
Flight::route('DELETE /companies/@id', function ($id) use ($companyService) {
    Flight::json($companyService->delete_company($id));
});

// GET /companies/search/name/@name
Flight::route('GET /companies/search/name/@name', function ($name) use ($companyService) {
    Flight::json($companyService->get_company_by_name($name));
});

// GET /companies/search/location/@location
Flight::route('GET /companies/search/location/@location', function ($location) use ($companyService) {
    Flight::json($companyService->get_company_by_location($location));
});
