<?php
require_once 'Repository.php';
require_once __DIR__ . '/../../models/User.php';

class UserRepository extends Repository
{
    public function getUser(): array
    {
        $result = [];
        $stmt = $this->database->connect()->prepare(
            'SELECT users.*, profile.picture_path FROM users LEFT JOIN profile ON users.id = profile.user_id;'
        );
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($users as $user) {
            $userObj = new User(
                $user['username'],
                $user['email'],
                $user['password'],
                $user['picture_path'],
                $user['role']
            );
            $userObj->setId($user['id']);
            $result[] = $userObj;
        }

        return $result;
    }

    public function getUserByEmail(string $email): ?User
    {
        $stmt = $this->database->connect()->prepare(
            'SELECT users.*, profile.picture_path FROM users LEFT JOIN profile ON users.id = profile.user_id WHERE email = :email'
        );
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
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

        return null;
    }
    public function addUser(User $user)
    {
        $stmt = $this->database->connect()->prepare(
            'INSERT INTO public.users(email, username, password, role) VALUES (?, ?, ?, ?)'
        );

        try {
            $stmt->execute([
                $user->getEmail(),
                $user->getUserName(),
                $user->getPassword(),
                $user->getRole(),
            ]);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            echo "SQLSTATE error code: " . $e->getCode();
            echo "Error Info: " . implode(", ", $stmt->errorInfo());
        }
    }
    public function userExists($email)
    {
        $stmt = $this->database->connect()->prepare(
            'SELECT * FROM public.users WHERE email = ?'
        );

        $stmt->execute([$email]);

        return $stmt->fetch() !== false;
    }
    public function getFriendsByUserId($userId): array
    {
        $result = [];
        $stmt = $this->database->connect()->prepare(
            'SELECT 
    u.*, 
    p.bio, 
    p.visited_places, 
    p.picture_path,
    STRING_AGG(ct.type, \',
            \') as favorite_cuisines
FROM public.users u
JOIN public.friendships f ON f.member2_id = u.id
JOIN public.profile p ON p.user_id = u.id
LEFT JOIN public.user_cuisine_preferences c ON c.user_id = u.id
LEFT JOIN public.cuisine_types ct ON ct.id = c.cuisine_id
WHERE f.member1_id = :userId
GROUP BY u.id, p.bio, p.visited_places, p.picture_path;'
        );
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $friends = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($friends as $friend) {
            $userObj = new User(
                $friend['username'],
                $friend['email'],
                $friend['password'],
                $friend['picture_path']
            );
            $userObj->setId($friend['id']);
            $userObj->setBio($friend['bio']);
            $userObj->setVisitedPlaces($friend['visited_places']);
            $userObj->setFavoriteCuisines($friend['favorite_cuisines']);
            $result[] = $userObj;
        }

        return $result;
    }
}
