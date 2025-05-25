<?php
require_once 'BaseService.class.php';
require_once __DIR__ . '/../dao/AuthDao.class.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;


class AuthService extends BaseService {
   private $auth_dao;
   public function __construct() {
       $this->auth_dao = new AuthDao();
       parent::__construct(new AuthDao);
   }


   public function get_user_by_email($email){
       return $this->auth_dao->get_user_by_email($email);
   }


   public function register($entity) {  
    // Validate required fields
    if (empty($entity['email']) || empty($entity['password']) || empty($entity['name']) || empty($entity['role'])) {
        return ['success' => false, 'error' => 'Name, email, password, and role are required.'];
    }

    // Check if email already exists
    $email_exists = $this->auth_dao->get_user_by_email($entity['email']);
    if ($email_exists) {
        return ['success' => false, 'error' => 'Email already registered.'];
    }

    // Hash the password
    $entity['password'] = password_hash($entity['password'], PASSWORD_BCRYPT);

    // Default date_joined if not set
    if (empty($entity['date_joined'])) {
        $entity['date_joined'] = date('Y-m-d');
    }

    // Optional fields: phone_number can be left null
    $entity = parent::create($entity);

    // Don't expose the hashed password
    unset($entity['password']);

    return ['success' => true, 'data' => $entity];             
}



   public function login($entity) {  
       if (empty($entity['email']) || empty($entity['password'])) {
           return ['success' => false, 'error' => 'Email and password are required.'];
       }


       $user = $this->auth_dao->get_user_by_email($entity['email']);
       if(!$user){
           return ['success' => false, 'error' => 'Invalid username or password.'];
       }


       if(!$user || !password_verify($entity['password'], $user['password']))
           return ['success' => false, 'error' => 'Invalid username or password.'];


       unset($user['password']);
      
       $jwt_payload = [
           'user' => $user,
           'iat' => time(),
           // If this parameter is not set, JWT will be valid for life. This is not a good approach
           'exp' => time() + (60 * 60 * 24) // valid for day
       ];


       $token = JWT::encode(
           $jwt_payload,
           Config::JWT_SECRET(),
           'HS256'
       );


       return ['success' => true, 'data' => array_merge($user, ['token' => $token])];             
   }
}
