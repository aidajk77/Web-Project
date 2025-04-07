<?php
require_once __DIR__ . "/BaseDao.php";

class JobCategoriesDao extends BaseDao
{
    protected $table_name;
    public function __construct()
    {
        $this->table_name = "jobcategories";
        parent::__construct($this->table_name);
    }

    public function get_all_categories()
    {
        $query = "SELECT * FROM " . $this->table_name;
        return $this->query($query, []);
    }

    public function get_category_by_id($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE category_id = :id";
        return $this->query_unique($query, ['id' => $id]);
    }
}
