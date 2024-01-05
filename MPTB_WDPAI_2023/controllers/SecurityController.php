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
    // public function updateProfile()
    // {
    //     session_start();
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         $userRepository = new UserRepository();

    //         $userId = $_SESSION['user_id'];
    //         $username = $_POST['username'];
    //         $email = $_POST['email'];
    //         $password = $_POST['password'];
    //         $likes = $_POST['likes'];
    //         $bio = $_POST['bio'];

    //         // Update the users table
    //         $userRepository->updateUser($userId, $username, $email, $password);

    //         // Update the profile in the users table
    //         $userRepository->updateUserProfile($userId, $bio, $likes);
    //     }
    // }
    public function updateProfile()
    {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userRepository = new UserRepository();

            $user = $userRepository->getUserByEmail($_SESSION['email']);
            if ($user === null) {
                header('Location: /mainmenu');
                exit;
            }

            $userId = $user->getId();  // Get the user ID from the User object

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
            // $likes = filter_input(INPUT_POST, 'likes', FILTER_SANITIZE_SPECIAL_CHARS);
            $bio = filter_input(INPUT_POST, 'bio', FILTER_SANITIZE_SPECIAL_CHARS);

            // Update the users table
            $userRepository->updateUser($userId, $username, $email, $password);

            // Update the profile in the users table
            // $userRepository->updateUserProfile($userId, $bio, $likes);
            $userRepository->updateUserProfile($userId, $bio,);
            header('Location: /mainmenu');
            exit;
        }
    }
}
