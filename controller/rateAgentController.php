<?php
require_once "../entity/rating.php";

class rateAgentController
{
    private Rating $rating;

    public function __construct()
    {
        $this->rating = new Rating();
    }

    public function rateAgent(array $rateInfo): bool
    {
        $rated = $this->rating->rateAgent($rateInfo);

        return $rated;
    }

    public function isRated(string $rater_username, string $agent_username): bool
    {
        $rated = $this->rating->isRated($rater_username, $agent_username);

        return $rated;
    }

}

?>