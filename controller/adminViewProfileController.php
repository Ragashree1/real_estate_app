<?php
require_once "../entity/profile.php";

class AdminViewProfileController
{
    private Profile $profile; 

    public function __construct()
    {
        $this->profile = new Profile();
    }

    public function getProfiles(): array
    {
        $allProfiles = $this->profile->getProfiles();

        return $allProfiles;
    }

}

?>