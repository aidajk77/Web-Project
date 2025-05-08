<?php
require_once __DIR__ . '/../services/CompaniesService.class.php';

$companyService = new CompanyService();

/**
 * @OA\Get(
 *     path="/companies",
 *     tags={"Companies"},
 *     summary="Get all companies",
 *     @OA\Response(
 *         response=200,
 *         description="List of all companies"
 *     ),
 *     security={{"ApiKey": {}}}
 * )
 */
Flight::route('GET /companies', function () use ($companyService) {
    Flight::json($companyService->get_all_companies());
});

/**
 * @OA\Get(
 *     path="/companies/{id}",
 *     tags={"Companies"},
 *     summary="Get company by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Company ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Company found"
 *     ),
 *     security={{"ApiKey": {}}}
 * )
 */
Flight::route('GET /companies/@id', function ($id) use ($companyService) {
    Flight::json($companyService->get_company_by_id($id));
});

/**
 * @OA\Post(
 *     path="/companies",
 *     tags={"Companies"},
 *     summary="Create new company",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name", "location", "description"},
 *             @OA\Property(property="name", type="string"),
 *             @OA\Property(property="location", type="string"),
 *             @OA\Property(property="description", type="string"),
 *             @OA\Property(property="website", type="string"),
 *             @OA\Property(property="email", type="string")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Company created successfully"
 *     ),
 *     security={{"ApiKey": {}}}
 * )
 */
Flight::route('POST /companies', function () use ($companyService) {
    $data = Flight::request()->data->getData();
    Flight::json($companyService->create_company($data));
});

/**
 * @OA\Put(
 *     path="/companies/{id}",
 *     tags={"Companies"},
 *     summary="Update company",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Company ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="name", type="string"),
 *             @OA\Property(property="location", type="string"),
 *             @OA\Property(property="description", type="string"),
 *             @OA\Property(property="website", type="string"),
 *             @OA\Property(property="email", type="string")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Company updated successfully"
 *     ),
 *     security={{"ApiKey": {}}}
 * )
 */
Flight::route('PUT /companies/@id', function ($id) use ($companyService) {
    $data = Flight::request()->data->getData();
    Flight::json($companyService->update_company($id, $data));
});

/**
 * @OA\Delete(
 *     path="/companies/{id}",
 *     tags={"Companies"},
 *     summary="Delete company",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Company ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Company deleted successfully"
 *     ),
 *     security={{"ApiKey": {}}}
 * )
 */
Flight::route('DELETE /companies/@id', function ($id) use ($companyService) {
    Flight::json($companyService->delete_company($id));
});

/**
 * @OA\Get(
 *     path="/companies/search/name/{name}",
 *     tags={"Companies"},
 *     summary="Search companies by name",
 *     @OA\Parameter(
 *         name="name",
 *         in="path",
 *         required=true,
 *         description="Company name to search for",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Companies matching the search"
 *     ),
 *     security={{"ApiKey": {}}}
 * )
 */
Flight::route('GET /companies/search/name/@name', function ($name) use ($companyService) {
    Flight::json($companyService->get_company_by_name($name));
});

/**
 * @OA\Get(
 *     path="/companies/search/location/{location}",
 *     tags={"Companies"},
 *     summary="Search companies by location",
 *     @OA\Parameter(
 *         name="location",
 *         in="path",
 *         required=true,
 *         description="Company location to search for",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Companies matching the location"
 *     ),
 *     security={{"ApiKey": {}}}
 * )
 */
Flight::route('GET /companies/search/location/@location', function ($location) use ($companyService) {
    Flight::json($companyService->get_company_by_location($location));
});
