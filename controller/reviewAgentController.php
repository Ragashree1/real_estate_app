<?php
require_once "../entity/review.php";

class ReviewAgentController
{
    private Review $review;

    public function __construct()
    {
        $this->review = new Review();
    }

    public function reviewAgent(array $reviewInfo): bool
    {
        $reviewed = $this->review->reviewAgent($reviewInfo);

        return $reviewed;
    }

    public function isReviewed(string $rater_username, string $agent_username): bool
    {
        $reviewed = $this->review->isReviewed($rater_username, $agent_username);

        return $reviewed;
    }
}

?>