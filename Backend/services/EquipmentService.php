<?php
require_once 'BaseService.php';
require_once __DIR__ . '/../dao/equipmentDao.php';

class EquipmentService extends BaseService {
    public function __construct() {
        $dao = new EquipmentDao();
        parent::__construct($dao);
    }
}
?>