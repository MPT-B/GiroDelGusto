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
        try {
            if (!$this->isPost()) {
                return $this->render('signup');
            }
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $passwordConfirmation = $_POST['passwordConfirmation'];

            if (empty($username)) {
                throw new Exception('Username cannot be empty');
            }

            if (strlen($password) < 8) {
                throw new Exception('Password must be at least 8 characters long');
            }

            if ($password !== $passwordConfirmation) {
                throw new Exception('Passwords do not match');
            }

            if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
                throw new Exception('Username can only contain letters, numbers, and underscores');
            }


            if ($this->userRepository->userExists($email)) {
                throw new Exception('A user with this email already exists');
            }

            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $user = new User($username, $email, $hashedPassword, 'normal');

            $this->addUser($user);

            return $this->render('login', ['messages' => ['You\'ve been succesfully registrated!']]);
        } catch (Exception $e) {
            if ($e->getMessage() === 'A user with this email already exists') {
                return $this->render('signup', ['messages' => ['A user with this email already exists']]);
            } else if ($e->getMessage() === 'Username can only contain letters, numbers, and underscores') {
                return $this->render('signup', ['messages' => ['Username can only contain letters, numbers, and underscores']]);
            } else if ($e->getMessage() === 'Passwords do not match') {
                return $this->render('signup', ['messages' => ['Passwords do not match']]);
            } else if ($e->getMessage() === 'Password must contain at least one letter and one number') {
                return $this->render('signup', ['messages' => ['Password must contain at least one letter and one number']]);
            } else {
                throw $e;
            }
        }
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
        $_SESSION["userId"] = $user->getId();
        $_SESSION['loggedin'] = true;
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

    public function logout()
    {
        session_start();
        session_destroy();
        header('Location: /login');
        exit;
    }
}
