<?php
require_once __DIR__ . "/BaseDao.php";

class ApplicationsDao extends BaseDao
{
    protected $table_name;
    public function __construct()
    {
        $this->table_name = "applications";
        parent::__construct($this->table_name);
    }

    public function get_application_by_id($id)
    {
        $query = "SELECT * FROM" . $this->table_name . " WHERE application_id = :id";
        return $this->query_unique($query, ['id' => $id]);
    }

    public function get_applications_by_user($user_id)
    {
        $query = "SELECT * FROM" . $this->table_name . " WHERE user_id = :user_id";
        return $this->query($query, ['user_id' => $user_id]);
    }

    public function get_applications_by_job($job_id)
    {
        $query = "SELECT * FROM" . $this->table_name . " WHERE job_id = :job_id";
        return $this->query($query, ['job_id' => $job_id]);
    }
}
