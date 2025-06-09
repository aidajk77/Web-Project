<?php
require_once __DIR__ . '/../services/BaseService.class.php';
require_once __DIR__ . '/../dao/JobsDao.class.php';

class JobService extends BaseService {

    public function __construct() {
        parent::__construct(new JobsDao());
    }

    public function get_all_jobs() {
        return $this->dao->get_all_jobs();
    }

    public function get_job_by_id($id) {
        if (!is_numeric($id) || $id <= 0) {
            throw new Exception("Invalid job ID.");
        }

        $job = $this->dao->get_job_by_id($id);
        if (!$job) {
            throw new Exception("Job not found.");
        }

        return $job;
    }

    public function create_job($job) {
        return $this->create($job);
    }

    public function update_job($id, $job) {
        if (!is_numeric($id) || $id <= 0) {
            throw new Exception("Invalid job ID.");
        }

        $existing = $this->dao->get_job_by_id($id);
        if (!$existing) {
            throw new Exception("Job with ID $id does not exist.");
        }

        $this->validate_job_data($job);

        return $this->update($id, $job);
    }

    public function delete_job($id) {
        if (!is_numeric($id) || $id <= 0) {
            throw new Exception("Invalid job ID.");
        }

        $job = $this->dao->get_job_by_id($id);
        if (!$job) {
            throw new Exception("Job not found.");
        }

        return $this->delete($id);
    }

    public function search_job_by_title($title) {
        if (empty($title) || strlen(trim($title)) < 2) {
            throw new Exception("Search title must be at least 2 characters.");
        }

        return $this->dao->search_job_by_title($title);
    }

    public function get_jobs_by_company($company_id) {
        if (!is_numeric($company_id) || $company_id <= 0) {
            throw new Exception("Invalid company ID.");
        }

        return $this->dao->get_jobs_by_company($company_id);
    }

    public function filter_jobs_by_location_paginated($offset, $limit, $location = null) {
        if (!is_numeric($offset) || $offset < 0 || !is_numeric($limit) || $limit <= 0) {
            throw new Exception("Invalid pagination parameters.");
        }

        return $this->dao->filter_jobs_by_location_paginated($offset, $limit, $location);
    }

    public function get_jobs_paginated($page = 1, $limit = 10) {
        if (!is_numeric($page) || $page <= 0 || !is_numeric($limit) || $limit <= 0) {
            throw new Exception("Invalid pagination parameters.");
        }

        $offset = ($page - 1) * $limit;
        $jobs = $this->dao->get_jobs_paginated($offset, $limit);
        $total = $this->dao->count_all_jobs();
        $totalPages = ceil($total / $limit);

        return [
            'jobs' => $jobs,
            'totalPages' => $totalPages,
            'totalCount' => $total
        ];
    }

    private function validate_job_data($job) {
        if (empty($job['title']) || strlen(trim($job['title'])) < 3) {
            throw new Exception("Job title is required and must be at least 3 characters.");
        }

        if (empty($job['description']) || strlen(trim($job['description'])) < 10) {
            throw new Exception("Job description is required and must be at least 10 characters.");
        }

        if (empty($job['location'])) {
            throw new Exception("Job location is required.");
        }

        if (empty($job['company_id']) || !is_numeric($job['company_id']) || $job['company_id'] <= 0) {
            throw new Exception("Valid company ID is required.");
        }

    }

}
