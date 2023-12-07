<?php
require_once 'AppController.php';
require_once __DIR__ . '/../models/User.php';
class SecurityController extends AppController
{
    private $db;
    public function __construct($db)
    {
        $this->db = $db;
    }

    public function register($username, $password)
    { {

            if (empty($username)) {
                throw new Exception('Username cannot be empty');
            }

            $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username");
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($user) {
                throw new Exception('Username already exists');
            }

            if (strlen($password) < 8) {
                throw new Exception('Password must be at least 8 characters long');
            }


            if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
                throw new Exception('Username can only contain letters, numbers, and underscores');
            }


            if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/', $password)) {
                throw new Exception('Password must contain at least one letter and one number');
            }




            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $this->db->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->execute();
        }
    }

    public function login($username, $password)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;
            return true;
        }

        return false;
    }
}
