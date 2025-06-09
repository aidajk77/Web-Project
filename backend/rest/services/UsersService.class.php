<?php
require_once __DIR__ . '/../services/BaseService.class.php';
require_once __DIR__ . '/../dao/UsersDao.class.php';

class UserService extends BaseService {

    public function __construct() {
        parent::__construct(new UsersDao());
    }

    public function get_all_users() {
        return $this->dao->get_all_users();
    }

    public function get_user_by_id($id) {
        if (!is_numeric($id) || $id <= 0) {
            throw new Exception("Invalid user ID.");
        }

        $user = $this->dao->get_user_by_id($id);
        if (!$user) {
            throw new Exception("User not found.");
        }

        return $user;
    }

    public function create_user($user) {
        return $this->create($user);
    }

    public function update_user($id, $user) {
        if (!is_numeric($id) || $id <= 0) {
            throw new Exception("Invalid user ID.");
        }

        $existing = $this->dao->get_user_by_id($id);
        if (!$existing) {
            throw new Exception("User with ID $id does not exist.");
        }

        $this->validate_user_data($user);

        return $this->dao->update_user($user, $id);
    }

    public function delete_user($id) {
        if (!is_numeric($id) || $id <= 0) {
            throw new Exception("Invalid user ID.");
        }

        $user = $this->dao->get_user_by_id($id);
        if (!$user) {
            throw new Exception("User not found.");
        }

        return $this->delete($id);
    }

    public function get_user_by_email($email) {
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email address.");
        }

        $user = $this->dao->get_user_by_email($email);
        if (!$user) {
            throw new Exception("User with email not found.");
        }

        return $user;
    }

    public function get_users_by_company($company_id) {
        if (!is_numeric($company_id) || $company_id <= 0) {
            throw new Exception("Invalid company ID.");
        }

        return $this->dao->get_users_by_company($company_id);
    }

    private function validate_user_data($user) {
        if (empty($user['name']) || strlen(trim($user['name'])) < 2) {
            throw new Exception("Full name is required and must be at least 2 characters.");
        }

        if (empty($user['email']) || !filter_var($user['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception("A valid email address is required.");
        }

        if (empty($user['password']) || strlen($user['password']) < 6) {
            throw new Exception("Password must be at least 6 characters long.");
        }

        if (!empty($user['phone_number']) && !preg_match('/^[\d\s\+\-]{7,20}$/', $user['phone_number'])) {
            throw new Exception("Invalid phone number format.");
        }

        if (!empty($user['role']) && !in_array($user['role'], ['user', 'admin'])) {
            throw new Exception("Invalid role. Only 'user' or 'admin' allowed.");
        }
    }
}
