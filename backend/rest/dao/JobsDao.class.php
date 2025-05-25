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
        $params = ['company_id' => $company_id];
        return $this->query($query, $params);
    }

    public function get_jobs_paginated($offset, $limit)
    {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY date_posted DESC LIMIT :offset, :limit";

        $stmt = $this->connection->prepare($query);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function count_all_jobs()
    {
        $query = "SELECT COUNT(*) as total FROM " . $this->table_name;
        $stmt = $this->connection->prepare($query);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }


    public function filter_jobs_by_location_paginated($offset, $limit, $location = null)
    {
        $query = "SELECT * FROM " . $this->table_name;
        $params = [
            'offset' => (int)$offset,
            'limit' => (int)$limit
        ];

        if ($location) {
            $query .= " WHERE location = :location";
            $params['location'] = $location;
        }

        $query .= " LIMIT :offset, :limit";

        // Use prepare + bindValue for LIMIT/OFFSET to avoid issues
        $stmt = $this->connection->prepare($query);
        if ($location) {
            $stmt->bindValue(':location', $location, PDO::PARAM_STR);
        }
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Add new job
    public function add_job($job)
    {
        return $this->add($job);
    }

    // Update job by ID
    public function update_job($id, $job)
    {
        return $this->update($job, $id);
    }

    // Delete job by ID
    public function delete_job($id)
    {
        return $this->delete($id);
    }
}
