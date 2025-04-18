<?php
require_once __DIR__ . "/BaseDao.php";

class SavedJobsDao extends BaseDao
{
    protected $table_name = "";
    public function __construct()
    {
        $this->table_name = "savedjobs";
        parent::__construct($this->table_name);
    }

    public function get_saved_jobs_by_user($user_id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE user_id = :user_id";
        return $this->query($query, ['user_id' => $user_id]);
    }

    public function get_users_who_saved_job($job_id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE job_id = :job_id";
        return $this->query($query, ['job_id' => $job_id]);
    }
}
