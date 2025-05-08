<?php
require_once 'BaseService.php';
require_once __DIR__ . '/../dao/userDao.php';

class UserService extends BaseService {
    private $userDao;

    public function __construct() {
        $this->userDao = new UserDao();
        parent::__construct($this->userDao);
    }

    public function register($data) {
        return $this->userDao->registerUser($data);
    }

    public function login($email, $password) {
        return $this->userDao->loginUser($email, $password);
    }

    public function getByEmail($email) {
        return $this->userDao->getUserByEmail($email);
    }

    public function getAllUsers() {
        return $this->getAll();
    }
    
}
?>
