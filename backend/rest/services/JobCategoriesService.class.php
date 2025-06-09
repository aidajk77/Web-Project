<?php
require_once __DIR__ . '/../services/BaseService.class.php';
require_once __DIR__ . '/../dao/JobCategoriesDao.class.php';

class JobCategoryService extends BaseService {

    public function __construct() {
        parent::__construct(new JobCategoriesDao());
    }

    public function get_all_categories() {
        return $this->getAll();
    }

    public function get_category_by_id($id) {
        if (!is_numeric($id) || $id <= 0) {
            throw new Exception("Invalid category ID.");
        }

        $category = $this->getById($id);
        if (!$category) {
            throw new Exception("Job category not found.");
        }

        return $category;
    }

    public function create_category($category) {
        return $this->create($category);
    }

    public function update_category($id, $category) {
        if (!is_numeric($id) || $id <= 0) {
            throw new Exception("Invalid category ID.");
        }

        $existing = $this->getById($id);
        if (!$existing) {
            throw new Exception("Category with ID $id does not exist.");
        }

        $this->validate_category_data($category);

        return $this->update($id, $category);
    }

    public function delete_category($id) {
        if (!is_numeric($id) || $id <= 0) {
            throw new Exception("Invalid category ID.");
        }

        $category = $this->getById($id);
        if (!$category) {
            throw new Exception("Job category not found.");
        }

        return $this->delete($id);
    }

    private function validate_category_data($category) {
        if (empty($category['category_name']) || strlen(trim($category['category_name'])) < 2) {
            throw new Exception("Category name is required and must be at least 2 characters long.");
        }

        
    }
}
