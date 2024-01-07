<?php
require_once 'Repository.php';
// require_once __DIR__ . '/../../models/Review.php';

class ReviewRepository extends Repository
{
    public function __construct()
    {
        $query = new Query();
        parent::__construct($query);
    }

    public function getFriendsFeed($userId): array
    {
        $result = [];
        $stmt = $this->database->prepare($this->query->getFriendsFeedQuery());
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $feed = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($feed as $item) {
            $result[] = $item;
        }

        return $result;
    }
    public function getFeed(): array
    {
        $result = [];
        $stmt = $this->database->prepare($this->query->getFeedQuery());
        $stmt->execute();
        $feed = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($feed as $item) {
            $result[] = $item;
        }

        return $result;
    }
    public function getUserFeed($userId): array
    {
        $result = [];
        $stmt = $this->database->prepare($this->query->getUserFeedQuery());
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $feed = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($feed as $item) {
            $result[] = $item;
        }

        return $result;
    }
    public function deleteReview($reviewId)
    {
        $stmt = $this->database->prepare('DELETE FROM reviews WHERE id = :reviewId');
        $stmt->execute([':reviewId' => $reviewId]);
    }

    public function isReviewOwner($reviewId, $userId): bool
    {
        $stmt = $this->database->prepare('SELECT * FROM reviews WHERE id = :reviewId AND user_id = :userId');
        $stmt->execute([':reviewId' => $reviewId, ':userId' => $userId]);
        return $stmt->fetch() !== false;
    }

    public function addReview(int $userId, int $restaurantId, int $rating, string $comment, string $foodOrdered)
    {
        $stmt = $this->database->prepare($this->query->addReviewQuery());
        $stmt->execute([$userId, $restaurantId, $rating, $comment, date('Y-m-d H:i:s'), $foodOrdered]);
    }
}
