<?php
require_once __DIR__ . '/../services/BaseService.class.php';
require_once __DIR__ . '/../dao/CompaniesDao.class.php';

class CompanyService extends BaseService {

    public function __construct() {
        parent::__construct(new CompaniesDao());
    }

    public function get_all_companies() {
        return $this->getAll();
    }

    public function get_company_by_id($id) {
        if (!is_numeric($id) || $id <= 0) {
            throw new Exception("Invalid company ID.");
        }

        $company = $this->getById($id);
        if (!$company) {
            throw new Exception("Company not found.");
        }

        return $company;
    }

    public function create_company($company) {
        return $this->create($company);
    }

    public function update_company($id, $company) {
        if (!is_numeric($id) || $id <= 0) {
            throw new Exception("Invalid company ID.");
        }

        $existing = $this->getById($id);
        if (!$existing) {
            throw new Exception("Company with ID $id does not exist.");
        }

        $this->validate_company_data($company);

        return $this->update($id, $company);
    }

    public function delete_company($id) {
        if (!is_numeric($id) || $id <= 0) {
            throw new Exception("Invalid company ID.");
        }

        $company = $this->getById($id);
        if (!$company) {
            throw new Exception("Company not found.");
        }

        return $this->delete($id);
    }

    public function get_company_by_name($name) {
        if (empty($name)) {
            throw new Exception("Company name is required.");
        }

        return $this->dao->get_company_by_name($name);
    }

    public function get_company_by_location($location) {
        if (empty($location)) {
            throw new Exception("Company location is required.");
        }

        return $this->dao->get_company_by_location($location);
    }

    private function validate_company_data($company) {
        if (empty($company['name']) || strlen(trim($company['name'])) < 2) {
            throw new Exception("Company name is required and must be at least 2 characters.");
        }

        if (empty($company['location'])) {
            throw new Exception("Company location is required.");
        }

        
    }
}
