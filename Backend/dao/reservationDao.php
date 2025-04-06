<?php
require_once 'baseDao.php';

class ReservationDao extends BaseDao {
    public function __construct() {
        parent::__construct('reservations');
    }
}
