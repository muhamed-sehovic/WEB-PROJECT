<?php

require_once 'BaseService.php';
require_once __DIR__ . '/../dao/studioDao.php';


class StudioService extends BaseService {
    public function __construct() {
        $dao = new StudioDao();
        parent::__construct($dao);
    }
}
 
?>
