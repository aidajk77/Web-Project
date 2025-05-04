<?php
/**
 * @OA\Info(
 *     title="JobMarket API",
 *     description="RESTful API for job marketplace application",
 *     version="1.0",
 *     @OA\Contact(
 *         email="aid.ajkunic@stu.ibu.edu.ba",
 *         name="Aid Ajkunic"
 *     )
 * )
 */

/**
 * @OA\Server(
 *     url="http://localhost/web-project/backend",
 *     description="API Server"
 * )
 */

/**
 * @OA\SecurityScheme(
 *     securityScheme="ApiKey",
 *     type="apiKey",
 *     in="header",
 *     name="Authentication"
 * )
 */

/**
 * @OA\Tag(
 *     name="Users",
 *     description="User management endpoints"
 * )
 */

/**
 * @OA\Tag(
 *     name="Companies",
 *     description="Company management endpoints"
 * )
 */

/**
 * @OA\Tag(
 *     name="Jobs",
 *     description="Job listing and management endpoints"
 * )
 */

/**
 * @OA\Tag(
 *     name="Job Categories",
 *     description="Job category management endpoints"
 * )
 */

/**
 * @OA\Tag(
 *     name="Job Category Mappings",
 *     description="Job and category relationship management endpoints"
 * )
 */

/**
 * @OA\Tag(
 *     name="Applications",
 *     description="Job application management endpoints"
 * )
 */

/**
 * @OA\Tag(
 *     name="Saved Jobs",
 *     description="Saved jobs management endpoints"
 * )
 */
