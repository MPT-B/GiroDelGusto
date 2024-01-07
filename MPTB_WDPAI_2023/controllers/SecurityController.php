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

            $this->validateSignupInput();

            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            $this->checkUserExistence($email);

            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $user = new User($username, $email, $hashedPassword, 'normal');

            $this->addUser($user);

            return $this->render('login', ['messages' => ['You\'ve been successfully registered!']]);
        } catch (Exception $e) {
            $errorMessage = $e->getMessage();
            return $this->handleSignupExceptions($errorMessage);
        }
    }

    private function validateSignupInput()
    {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $passwordConfirmation = $_POST['passwordConfirmation'];

        if (
            empty($username) || strlen($password) < 8 || $password !== $passwordConfirmation
            || !preg_match('/^[a-zA-Z0-9_]+$/', $username)
        ) {
            throw new Exception('Invalid input for signup');
        }
    }

    private function checkUserExistence($email)
    {
        if ($this->userRepository->userExists($email)) {
            throw new Exception('A user with this email already exists');
        }
    }

    private function handleSignupExceptions($errorMessage)
    {
        $messages = [$errorMessage];

        switch ($errorMessage) {
            case 'A user with this email already exists':
                return $this->render('signup', ['messages' => $messages]);
            case 'Invalid input for signup':
                return $this->render('signup', ['messages' => $messages]);
            default:
                throw new Exception($errorMessage);
        }
    }

    public function login()
    {
        if (!$this->isPost()) {
            return $this->render('login');
        }

        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = $this->getUserByEmail($email);

        if (!$user || !password_verify($password, $user->getPassword())) {
            return $this->render('login', ['messages' => ['Invalid credentials']]);
        }

        $this->startSession($email, $user->getId());
        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/mainmenu");
    }

    private function startSession($email, $userId)
    {
        session_start();
        $_SESSION["email"] = $email;
        $_SESSION["userId"] = $userId;
        $_SESSION['loggedin'] = true;
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

    private function addUser(User $newUser)
    {
        $this->userRepository->addUser($newUser);
    }
    public function updateProfile()
    {
        session_start();
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $userRepository = new UserRepository();

                $user = $userRepository->getUserByEmail($_SESSION['email']);
                if ($user === null) {
                    header('Location: /mainmenu');
                    exit;
                }

                $userId = $user->getId();

                $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
                $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    throw new Exception('Invalid email format');
                }
                $password = filter_input(
                    INPUT_POST,
                    'password',
                    FILTER_SANITIZE_SPECIAL_CHARS
                );
                $passwordConfirmation = filter_input(
                    INPUT_POST,
                    'passwordConfirmation',
                    FILTER_SANITIZE_SPECIAL_CHARS
                );
                if ($password !== $passwordConfirmation) {
                    throw new Exception('Password and confirmation password do not match');
                }
                $bio = filter_input(INPUT_POST, 'bio', FILTER_SANITIZE_SPECIAL_CHARS);
                $userRepository->updateUser($userId, $username, $email, $password);
                $userRepository->updateUserProfile($userId, $bio);
                header('Location: /mainmenu');
                exit;
            }
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            header('Location: /userProfileSettings');
            exit;
        }
    }
}
