<?php
require_once "../entity/rating.php";

class ViewAgentRatingController
{
    private Rating $rating;

    public function __construct()
    {
        $this->rating = new Rating();
    }

    public function getAllRatings(string $agent_username): array
    {
        $allListings = $this->rating->getAllRatings($agent_username);

        return $allListings;
    }

}

?>