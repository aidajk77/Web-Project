<?php
require_once __DIR__ . '/../services/BaseService.class.php';
require_once __DIR__ . '/../dao/JobCategoryMappingDao.class.php';

class JobCategoryMappingService extends BaseService {

    public function __construct() {
        parent::__construct(new JobCategoryMappingDao());
    }

    public function get_categories_by_job($job_id) {
        if (!is_numeric($job_id) || $job_id <= 0) {
            throw new Exception("Invalid job ID.");
        }

        return $this->dao->get_categories_by_job($job_id);
    }

    public function get_jobs_by_category($category_id) {
        if (!is_numeric($category_id) || $category_id <= 0) {
            throw new Exception("Invalid category ID.");
        }

        return $this->dao->get_jobs_by_category($category_id);
    }

    public function create_mapping($mapping) {
        return $this->create($mapping);
    }

    public function update_mapping($id, $mapping) {
        if (!is_numeric($id) || $id <= 0) {
            throw new Exception("Invalid mapping ID.");
        }

        $existing = $this->getById($id);
        if (!$existing) {
            throw new Exception("Mapping with ID $id does not exist.");
        }

        $this->validate_mapping_data($mapping);

        return $this->update($id, $mapping);
    }

    public function delete_mapping($id) {
        if (!is_numeric($id) || $id <= 0) {
            throw new Exception("Invalid mapping ID.");
        }

        $mapping = $this->getById($id);
        if (!$mapping) {
            throw new Exception("Mapping not found.");
        }

        return $this->delete($id);
    }

    private function validate_mapping_data($mapping) {
        if (empty($mapping['job_id']) || !is_numeric($mapping['job_id']) || $mapping['job_id'] <= 0) {
            throw new Exception("Invalid or missing job ID.");
        }

        if (empty($mapping['category_id']) || !is_numeric($mapping['category_id']) || $mapping['category_id'] <= 0) {
            throw new Exception("Invalid or missing category ID.");
        }
    }
}
