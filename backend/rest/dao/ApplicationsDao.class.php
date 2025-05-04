<?php
require_once __DIR__ . "/BaseDao.class.php";

class ApplicationsDao extends BaseDao
{
    protected $table_name;

    public function __construct()
    {
        $this->table_name = "applications";
        parent::__construct($this->table_name);
    }

    public function get_all_applications()
    {
        return $this->getAll();
    }

    public function get_application_by_id($id)
    {
        // Assuming your primary key is application_id instead of id
        $query = "SELECT * FROM " . $this->table_name . " WHERE application_id = :id";
        return $this->query_unique($query, ['id' => $id]);
    }

    public function get_applications_by_user($user_id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE user_id = :user_id";
        return $this->query($query, ['user_id' => $user_id]);
    }

    public function get_applications_by_job($job_id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE job_id = :job_id";
        return $this->query($query, ['job_id' => $job_id]);
    }

    // Use BaseDao's add() method
    public function add_application($application)
    {
        return $this->add($application);
    }

    // Use BaseDao's update() method
    public function update_application($id, $application)
    {
        // application_id is the column name used as primary key
        return $this->update($application, $id, "application_id");
    }

    // Use BaseDao's delete() method
    public function delete_application($id)
    {
        return $this->delete($id);
    }
}
