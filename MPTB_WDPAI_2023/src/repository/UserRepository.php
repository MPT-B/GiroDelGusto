<?php
require_once 'Repository.php';
require_once __DIR__ . '/../../models/User.php';

class UserRepository extends Repository
{
    public function getUser(): array
    {
        $result = [];
        $stmt = $this->database->connect()->prepare(
            'SELECT * FROM users;'
        );
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($users as $user) {
            $userObj = new User(
                $user['username'],
                $user['email'],
                $user['password'],
            );
            $userObj->setId($user['id']);
            $result[] = $userObj;
        }

        return $result;
    }

    public function getUserByEmail(string $email): ?User
    {
        $stmt = $this->database->connect()->prepare(
            'SELECT * FROM users WHERE email = :email'
        );
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $userObj = new User(
                $user['username'],
                $user['email'],
                $user['password']
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
}
