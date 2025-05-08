<?php
require_once 'BaseService.php';
require_once __DIR__ . '/../dao/reservationDao.php';

class ReservationService extends BaseService {
    public function __construct() {
        $dao = new ReservationDao();
        parent::__construct($dao);
    }
}
?>
