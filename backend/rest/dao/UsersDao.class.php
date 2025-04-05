<?php
require_once __DIR__ . "/BaseDao..class.php";

class UsersDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct("users");
    }

    public function get_user_by_id($id)
    {
        $query = "SELECT * FROM users WHERE user_id = :id";
        return $this->query_unique($query, ['id' => $id]);
    }

    public function get_user_by_email($email)
    {
        $query = "SELECT * FROM users WHERE email = :email";
        return $this->query_unique($query, ['email' => $email]);
    }

    public function get_users_by_company($company_id)
    {
        $query = "SELECT * FROM users WHERE company_id = :company_id";
        return $this->query($query, ['company_id' => $company_id]);
    }
}
