<?php
require_once 'baseDao.php';

class UserDao extends BaseDao {
    public function __construct() {
        parent::__construct('users');
    }

    public function registerUser($data) {
        if ($this->getUserByEmail($data['email'])) {
            return "User already registered.";
        }

        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        return $this->insert($data);
    }

    public function loginUser($email, $password) {
        $user = $this->getUserByEmail($email);
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return null;
    }

    public function getUserByEmail($email) {
        $stmt = $this->connection->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
