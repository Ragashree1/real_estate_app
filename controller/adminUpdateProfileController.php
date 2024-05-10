<?php
require_once "../entity/Profile.php";

class AdminUpdateProfileController
{
    private Profile $profile; 

    public function __construct()
    {
        $this->profile = new Profile();
    }

    public function updateProfile(array $profileDetails) : bool
    {
        $status = $this->profile->updateProfile($profileDetails);
        return $status != null && $status != false;
    }
}

?>