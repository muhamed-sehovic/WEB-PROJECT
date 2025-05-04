<?php
require_once 'BaseService.php';
require_once __DIR__ . '/../dao/reviewDao.php';

class ReviewService extends BaseService {
    public function __construct() {
        $dao = new ReviewDao();
        parent::__construct($dao);
    }
}
?>
