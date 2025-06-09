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
        if (!is_numeric($id) || $id <= 0) {
            throw new Exception("Invalid application ID.");
        }

        $application = $this->getById($id);
        if (!$application) {
            throw new Exception("Application not found.");
        }

        return $application;
    }

    public function create_application($application) {
        return $this->create($application);
    }

    public function update_application($id, $application) {
        if (!is_numeric($id) || $id <= 0) {
            throw new Exception("Invalid application ID.");
        }

        $existing = $this->dao->getById($id);
        if (!$existing) {
            throw new Exception("Application with ID $id does not exist.");
        }


        return $this->update($id, $application);
    }

    public function delete_application($id) {
        if (!is_numeric($id) || $id <= 0) {
            throw new Exception("Invalid application ID.");
        }

        $application = $this->getById($id);
        if (!$application) {
            throw new Exception("Application not found.");
        }

        return $this->delete($id);
    }

    public function get_applications_by_user($user_id) {
        if (!is_numeric($user_id) || $user_id <= 0) {
            throw new Exception("Invalid user ID.");
        }

        return $this->dao->get_applications_by_user($user_id);
    }

    public function get_applications_by_job($job_id) {
        if (!is_numeric($job_id) || $job_id <= 0) {
            throw new Exception("Invalid job ID.");
        }

        return $this->dao->get_applications_by_job($job_id);
    }

    public function get_info_about_applications(){
        return $this->dao->get_info_about_applications();
    }


    private function validate_application_data($application) {
        if (empty($application['user_id']) || empty($application['job_id'])) {
            throw new Exception("User ID and Job ID are required.");
        }

        if (!is_numeric($application['user_id']) || $application['user_id'] <= 0) {
            throw new Exception("Invalid User ID.");
        }

        if (!is_numeric($application['job_id']) || $application['job_id'] <= 0) {
            throw new Exception("Invalid Job ID.");
        }

        
    }
}
