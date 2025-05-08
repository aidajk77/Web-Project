<?php
require_once __DIR__ . "/BaseDao.class.php";

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
        return $this->getAll();
    }

    public function get_category_by_id($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE category_id = :id";
        return $this->query_unique($query, ['id' => $id]);
    }

    // Use BaseDao's add() method
    public function add_category($category)
    {
        return $this->add($category);
    }

    // Use BaseDao's update() method
    public function update_category($id, $category)
    {
        return $this->update($category, $id, "category_id");
    }

    // Use BaseDao's delete() method
    public function delete_category($id)
    {
        return $this->delete($id);
    }
}
