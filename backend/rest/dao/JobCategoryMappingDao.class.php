<?php
require_once __DIR__ . "/BaseDao.php";

class JobCategoryMappingDao extends BaseDao
{
    protected $table_name;
    public function __construct()
    {
        $this->table_name = "jobcategorymapping";
        parent::__construct($this->table_name);
    }

    public function get_categories_by_job($job_id)
    {
        $query = "SELECT jc.* 
                  FROM jobcategorymapping jcm
                  JOIN jobcategories jc ON jcm.category_id = jc.category_id
                  WHERE jcm.job_id = :job_id";
        return $this->query($query, ['job_id' => $job_id]);
    }

    public function get_jobs_by_category($category_id)
    {
        $query = "SELECT j.* 
                  FROM jobcategorymapping jcm
                  JOIN jobs j ON jcm.job_id = j.job_id
                  WHERE jcm.category_id = :category_id";
        return $this->query($query, ['category_id' => $category_id]);
    }
}
