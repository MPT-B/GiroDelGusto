<?php
require_once 'Repository.php';
require_once __DIR__ . '/../../models/User.php';

class UserRepository extends Repository
{
    public function __construct()
    {
        parent::__construct(new Query());
    }

    private function createUser(array $user): User
    {
        $userObj = new User(
            $user['username'],
            $user['email'],
            $user['password'],
            $user['picture_path'],
            $user['role']
        );
        $userObj->setId($user['id']);

        return $userObj;
    }
    private function createProfile(int $userId): void
    {
        try {
            $profile = $this->getUserProfile($userId);
        } catch (Exception $e) {
            // If the user profile does not exist, create a new one
            $stmt = $this->database->prepare("INSERT INTO public.profile(user_id, bio) VALUES (?, 'New to Grio')");
            $stmt->execute([$userId]);
        }
    }
    public function getUser(): array
    {
        $result = [];
        $stmt = $this->database->prepare($this->query->getUserQuery());
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($users as $user) {
            $result[] = $this->createUser($user);
        }

        return $result;
    }

    public function getUserByEmail(string $email): ?User
    {
        $stmt = $this->database->prepare($this->query->getUserByEmailQuery());
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ? $this->createUser($user) : null;
    }

    public function getUserById(string $id): ?User
    {
        $stmt = $this->database->prepare($this->query->getUserByIdQuery());
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ? $this->createUser($user) : null;
    }
    public function addUser(User $user)
    {
        if ($this->userExists($user->getEmail())) {
            throw new Exception("User with email {$user->getEmail()} already exists");
        }
        $stmt = $this->database->prepare($this->query->addUserQuery());
        $stmt->execute([
            $user->getEmail(),
            $user->getUserName(),
            $user->getPassword(),
            $user->getRole(),
        ]);

        $userId = $this->database->lastInsertId();
        $this->createProfile($userId);
    }

    public function userExists($email)
    {
        $stmt = $this->database->prepare($this->query->userExistsQuery());
        $stmt->execute([$email]);

        return $stmt->fetch() !== false;
    }
    public function getFriendsByUserId($userId): array
    {
        $result = [];
        $stmt = $this->database->prepare($this->query->getFriendsByUserIdQuery());
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $friends = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($friends as $friend) {
            $userObj = $this->createUser($friend);
            $userObj->setBio($friend['bio']);
            $userObj->setVisitedPlaces($friend['visited_places']);
            $userObj->setFavoriteCuisines($friend['favorite_cuisines']);
            $result[] = $userObj;
        }

        return $result;
    }
    public function getUserProfile($userId)
    {
        $stmt = $this->database->prepare($this->query->getUserProfile());
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $userObj = $this->createUser($user);
            $userObj->setBio($user['bio']);
            $userObj->setVisitedPlaces($user['visited_places']);
            $userObj->setFavoriteCuisines($user['favorite_cuisines']);

            return $userObj;
        }

        throw new Exception("User not found");
    }

    public function updateUser($userId, $username, $email, $password)
    {
        $stmt = $this->database->prepare('UPDATE users SET username = :username, email = :email, password = :password WHERE id = :userId');
        $stmt->execute([':username' => $username, ':email' => $email, ':password' => password_hash($password, PASSWORD_BCRYPT), ':userId' => $userId]);
    }

    public function updateUserProfile($userId, $bio)
    {
        $stmt = $this->database->prepare('UPDATE profile SET bio = :bio WHERE user_id = :userId');
        $stmt->execute([':bio' => $bio, ':userId' => $userId]);
    }
}
