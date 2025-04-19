<?php
require_once __DIR__ . '/../services/BaseService.php';
require_once __DIR__ . '/../dao/CompaniesDao.php';

class CompanyService extends BaseService {

    public function __construct() {
        parent::__construct(new CompaniesDao());
    }

    public function get_all_companies() {
        return $this->getAll();
    }

    public function get_company_by_id($id) {
        return $this->getById($id);
    }

    public function create_company($company) {
        return $this->create($company);
    }

    public function update_company($id, $company) {
        return $this->update($id, $company);
    }

    public function delete_company($id) {
        return $this->delete($id);
    }

    public function get_company_by_name($name) {
        return $this->dao->get_company_by_name($name);
    }

    public function get_company_by_location($location) {
        return $this->dao->get_company_by_location($location);
    }
}
