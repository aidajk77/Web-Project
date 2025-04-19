<?php
require_once __DIR__ . '/../services/BaseService.php';
require_once __DIR__ . '/../dao/JobCategoryMappingDao.php';

class JobCategoryMappingService extends BaseService {

    public function __construct() {
        parent::__construct(new JobCategoryMappingDao());
    }

    public function get_categories_by_job($job_id) {
        return $this->dao->get_categories_by_job($job_id);
    }

    public function get_jobs_by_category($category_id) {
        return $this->dao->get_jobs_by_category($category_id);
    }

    public function create_mapping($mapping) {
        return $this->create($mapping);
    }

    public function update_mapping($id, $mapping) {
        return $this->update($id, $mapping);
    }

    public function delete_mapping($id) {
        return $this->delete($id);
    }
}
