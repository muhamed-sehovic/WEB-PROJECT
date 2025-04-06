<?php
require_once 'baseDao.php';

class ReviewDao extends BaseDao {
    public function __construct() {
        parent::__construct('reviews');
    }
}