<?php

require_once 'AppController.php';
require_once __DIR__ . '/../models/User.php';

class SecurityController extends AppController
{
    private $userRepository;
    public function __construct()
    {
        parent::__construct();
        $this->userRepository = [
            new User("JT", "J@T.com", password_hash('asd', PASSWORD_BCRYPT)),
            new User("ST", "S@T.com", password_hash('zxc', PASSWORD_BCRYPT)),
            new User("XC", "X@C.com", password_hash('qwe', PASSWORD_BCRYPT)),
        ];
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

        // if ($this->user->getEmail() === $username) {
        //     throw new Exception('Username already exists');
        // }

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

        return $this->render('login', ['messages' => ['You\'ve been succesfully registrated!']]);
    }
    public function addUser(User $newUser)
    {
        $this->userRepository[] = $newUser;
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
            return $this->render('login');
        }

        if ($user->getEmail() !== $email) {
            return $this->render('login', ['messages' => ['User with this email does not exist!']]);
        }

        if (!password_verify($password, $user->getPassword())) {
            var_dump($user->getPassword());
            var_dump($_POST['password']);
            return $this->render('login', ['messages' => ['Wrong password!']]);
        }

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/mainmenu");
    }
    private function getUserByEmail($email)
    {
        foreach ($this->userRepository as $user) {
            if ($user->getEmail() === $email) {
                return $user;
            }
        }
        return null;
    }
}
