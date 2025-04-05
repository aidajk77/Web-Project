<?php
require_once __DIR__ . '/BaseDao.class.php';

class JobsDao extends BaseDao
{

    protected $table_name;
    public function __construct()
    {
        $this->table_name = "jobs";
        parent::__construct($this->table_name);
    }

    public function get_all_jobs()
    {
        return $this->query('SELECT * FROM ' . $this->table_name, []);
    }

    public function get_job_by_id($id)
    {
        $query = "SELECT * FROM jobs WHERE id = :id";
        return $this->query_unique($query, ['id' => $id]);
    }

    public function search_job_by_title($title)
    {
        $query = "SELECT * FROM jobs WHERE title LIKE :title";
        $params = ['title' => '%' . $title . '%'];
        return $this->query($query, $params);
    }

    public function get_jobs_by_company($company_id)
    {
        $query = "SELECT * FROM jobs WHERE company_id = :company_id";
        $params=['company_id' => $company_id];
        return $this->query($query, $params);
    }

    public function filter_jobs_by_location_paginated($offset, $limit, $location=null)
    {
        $query = "SELECT * FROM " . $this->table_name;
        $params = [
            'offset' => $offset,
            'limit' => $limit
        ];

        if ($location) {
            $query .= " WHERE location = :location";
            $params['location'] = $location;
        }

        $query .= " LIMIT :offset, :limit";
        
        return $this->query($query, $params);
    }
    
}
