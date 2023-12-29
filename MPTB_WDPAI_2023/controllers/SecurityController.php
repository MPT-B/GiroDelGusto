<?php
require_once 'AppController.php';
require_once __DIR__ . '/../src/repository/UserRepository.php';

class SecurityController extends AppController
{
    private $userRepository;
    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
    }

    public function signup()
    {
        if (!$this->isPost()) {
            return $this->render('signup');
        }
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        if (empty($username)) {
            throw new Exception('Username cannot be empty');
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
        $user = new User($username, $email, $hashedPassword);

        $this->addUser($user);

        return $this->render('login', ['messages' => ['You\'ve been succesfully registered!']]);
    }

    public function addUser(User $newUser)
    {
        $this->userRepository->addUser($newUser);
    }

    public function login()
    {
        if (!$this->isPost()) {
            return $this->render('login');
        }

        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = $this->getUserByEmail($email);
        if (!$user) {
            return $this->render('login', ['messages' => ['User with this email does not exist!']]);
        }

        if (!password_verify($password, $user->getPassword())) {
            return $this->render('login', ['messages' => ['Wrong password!']]);
        }
        session_start();
        $_SESSION["email"] = $email;
        $_SESSION["userId"] = $user->getId(); // Add the user ID to the session
        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/mainmenu");
    }
    private function getUserByEmail($email)
    {
        return $this->userRepository->getUserByEmail($email);
    }
    public function getAllUsers()
    {
        return $this->userRepository->getUser();
    }
}
