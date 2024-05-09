<?php
require_once "../entity/review.php";

class ViewAgentReviewController
{
    private Review $review;

    public function __construct()
    {
        $this->review = new Review();
    }

    public function getAllReviews(string $agent_username): array
    {
        $allListings = $this->review->getAllReviews($agent_username);

        return $allListings;
    }

}

?>