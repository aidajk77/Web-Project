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
        return $this->dao->get_user_by_id($id);
    }

    public function create_user($user) {
        return $this->create($user);
    }

    public function update_user($id, $user) {
        return $this->dao->update_user($id, $user);
    }

    public function delete_user($id) {
        return $this->delete($id);
    }

    public function get_user_by_email($email) {
        return $this->dao->get_user_by_email($email);
    }

    public function get_users_by_company($company_id) {
        return $this->dao->get_users_by_company($company_id);
    }
}
