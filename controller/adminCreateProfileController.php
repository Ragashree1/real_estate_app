<?php
require_once "../entity/Profile.php";

class AdminCreateProfileController
{
    private Profile $profile; 

    public function __construct()
    {
        $this->profile = new Profile();
    }

    public function createProfile(array $profileDetails) : bool
    {
        $status = $this->profile->createProfile($profileDetails);
        return $status;
    }
}

?>