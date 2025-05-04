<?php
require_once __DIR__ . '/../services/BaseService.class.php';
require_once __DIR__ . '/../dao/ApplicationsDao.class.php';

class ApplicationService extends BaseService {

    public function __construct() {
        parent::__construct(new ApplicationsDao());
    }

    public function get_all_applications() {
        return $this->getAll();
    }

    public function get_application_by_id($id) {
        return $this->getById($id);
    }

    public function create_application($application) {
        return $this->create($application);
    }

    public function update_application($id, $application) {
        return $this->update($id, $application);
    }

    public function delete_application($id) {
        return $this->delete($id);
    }

    public function get_applications_by_user($user_id) {
        return $this->dao->get_applications_by_user($user_id);
    }

    public function get_applications_by_job($job_id) {
        return $this->dao->get_applications_by_job($job_id);
    }
}
