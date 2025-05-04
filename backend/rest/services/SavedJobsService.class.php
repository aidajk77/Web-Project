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
        return $this->getById($id);
    }

    public function create_saved_job($saved_job) {
        return $this->create($saved_job);
    }

    public function update_saved_job($id, $saved_job) {
        return $this->update($id, $saved_job);
    }

    public function delete_saved_job($id) {
        return $this->delete($id);
    }

    public function get_saved_jobs_by_user($user_id) {
        return $this->dao->get_saved_jobs_by_user($user_id);
    }

    public function get_users_who_saved_job($job_id) {
        return $this->dao->get_users_who_saved_job($job_id);
    }
}
