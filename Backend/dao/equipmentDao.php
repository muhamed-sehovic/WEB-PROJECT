<?php
require_once 'baseDao.php';

class EquipmentDao extends BaseDao {
    public function __construct() {
        parent::__construct('equipment');
    }
}