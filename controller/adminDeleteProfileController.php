<?php
require_once "../entity/Profile.php";

class AdminDeleteProfileController
{
    private Profile $profile; 

    public function __construct()
    {
        $this->profile = new Profile();
    }

    public function deleteProfile(string $profile)
    {
        $status = $this->profile->deleteProfile($profile);

        return $status;
    }

}

?>