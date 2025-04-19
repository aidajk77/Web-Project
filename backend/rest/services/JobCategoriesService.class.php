<?php
require_once __DIR__ . '/../services/BaseService.php';
require_once __DIR__ . '/../dao/JobCategoriesDao.php';

class JobCategoryService extends BaseService {

    public function __construct() {
        parent::__construct(new JobCategoriesDao());
    }

    public function get_all_categories() {
        return $this->getAll();
    }

    public function get_category_by_id($id) {
        return $this->getById($id);
    }

    public function create_category($category) {
        return $this->create($category);
    }

    public function update_category($id, $category) {
        return $this->update($id, $category);
    }

    public function delete_category($id) {
        return $this->delete($id);
    }
}
