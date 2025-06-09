<?php
require_once __DIR__ . '/../services/BaseService.class.php';
require_once __DIR__ . '/../dao/SavedJobsDao.class.php';

class SavedJobService extends BaseService {

    public function __construct() {
        parent::__construct(new SavedJobsDao());
    }

    public function get_all_saved_jobs() {
        return $this->getAll();
    }

    public function get_saved_job_by_id($id) {
        if (!is_numeric($id) || $id <= 0) {
            throw new Exception("Invalid saved job ID.");
        }

        $savedJob = $this->getById($id);
        if (!$savedJob) {
            throw new Exception("Saved job not found.");
        }

        return $savedJob;
    }

    public function create_saved_job($saved_job) {
        return $this->create($saved_job);
    }

    public function update_saved_job($id, $saved_job) {
        if (!is_numeric($id) || $id <= 0) {
            throw new Exception("Invalid saved job ID.");
        }

        $existing = $this->getById($id);
        if (!$existing) {
            throw new Exception("Saved job with ID $id does not exist.");
        }

        $this->validate_saved_job_data($saved_job);

        return $this->update($id, $saved_job);
    }

    public function delete_saved_job($id) {
        if (!is_numeric($id) || $id <= 0) {
            throw new Exception("Invalid saved job ID.");
        }

        $savedJob = $this->getById($id);
        if (!$savedJob) {
            throw new Exception("Saved job not found.");
        }

        return $this->delete($id);
    }

    public function get_saved_jobs_by_user($user_id) {
        if (!is_numeric($user_id) || $user_id <= 0) {
            throw new Exception("Invalid user ID.");
        }

        return $this->dao->get_saved_jobs_by_user($user_id);
    }

    public function get_users_who_saved_job($job_id) {
        if (!is_numeric($job_id) || $job_id <= 0) {
            throw new Exception("Invalid job ID.");
        }

        return $this->dao->get_users_who_saved_job($job_id);
    }

    private function validate_saved_job_data($saved_job) {
        if (empty($saved_job['user_id']) || !is_numeric($saved_job['user_id']) || $saved_job['user_id'] <= 0) {
            throw new Exception("Valid user ID is required.");
        }

        if (empty($saved_job['job_id']) || !is_numeric($saved_job['job_id']) || $saved_job['job_id'] <= 0) {
            throw new Exception("Valid job ID is required.");
        }
    }
}
