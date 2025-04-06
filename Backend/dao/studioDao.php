<?php
require_once 'baseDao.php';

class StudioDao extends BaseDao {
    public function __construct() {
        parent::__construct('studios');
    }
}