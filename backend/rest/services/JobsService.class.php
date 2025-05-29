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
        return $this->dao->get_job_by_id($id);
    }

    public function create_job($job) {
        return $this->create($job);
    }

    public function update_job($id, $job) {
        return $this->update($id, $job);
    }

    public function delete_job($id) {
        return $this->delete($id);
    }

    public function search_job_by_title($title) {
        return $this->dao->search_job_by_title($title);
    }

    public function get_jobs_by_company($company_id) {
        return $this->dao->get_jobs_by_company($company_id);
    }

    public function filter_jobs_by_location_paginated($offset, $limit, $location = null) {
        return $this->dao->filter_jobs_by_location_paginated($offset, $limit, $location);
    }

    public function get_jobs_paginated($page = 1, $limit = 10)
    {
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

}
