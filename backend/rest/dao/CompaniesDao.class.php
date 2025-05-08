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

    public function get_all_companies()
    {
        return $this->getAll();
    }

    public function get_company_by_id($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE company_id = :id";
        return $this->query_unique($query, ['id' => $id]);
    }

    public function get_company_by_name($name)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE name LIKE :name";
        return $this->query($query, ['name' => '%' . $name . '%']);
    }

    public function get_company_by_location($location)
    {
        $query = "SELECT * FROM " . $this->table_name;
        $params = [];

        if ($location) {
            $query .= " WHERE location = :location";
            $params['location'] = $location;
        }

        return $this->query($query, $params);
    }

    // Use BaseDao's add() method
    public function add_company($company)
    {
        return $this->add($company);
    }

    // Use BaseDao's update() method
    public function update_company($id, $company)
    {
        return $this->update($company, $id, "company_id");
    }

    // Use BaseDao's delete() method
    public function delete_company($id)
    {
        return $this->delete($id);
    }
}
