<?php
require_once __DIR__ . "/BaseDao.class.php";

class CompaniesDao extends BaseDao
{
    protected $table_name;
    public function __construct()
    {
        $this->table_name = "companies";
        parent::__construct($this->table_name);
    }

    public function get_company_by_id($id)
    {
        $query = "SELECT * FROM" . $this->table_name . "WHERE company_id = :id";
        return $this->query_unique($query, ['id' => $id]);
    }

    public function get_company_by_name($name)
    {
        $query = "SELECT * FROM" . $this->table_name . "WHERE name LIKE :name";
        return $this->query($query, ['name' => '%' . $name . '%']);
    }

    public function get_company_by_location($location){
        $query = "SELECT * FROM " . $this->table_name;

        if ($location) {
            $query .= " WHERE location = :location";
        }
        return $this->query($query, ['location'=> $location]);
        
    }
}
