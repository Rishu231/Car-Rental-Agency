<?php
class UserModel {
    private $conn;

    public function __construct() {
        $this->conn = (new Database())->getConnection();
    }

    public function registerUser($username, $email, $password, $role) {
        $stmt = $this->conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $email, $password, $role);
        return $stmt->execute();
    }

    public function loginUser($username, $password) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        // echo $user;
        if (password_verify($password, $user['password'])) {
            return $user;
        } else {
            return false;
        }
    }
}
?>
