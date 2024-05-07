<?php
require_once "../entity/profile.php";

class SearchProfileController
{
    private Profile $profile; 

    public function __construct()
    {
        $this->profile = new Profile();
    }

    public function searchProfiles(string $name): array
    {
        $allProfiles = $this->profile->searchProfiles($name);

        return $allProfiles;
    }

}

?>