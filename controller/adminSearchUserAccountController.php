<?php
require_once "../entity/userAccount.php";

class AdminSearchUserAccountController
{
    private UserAccount $userAccount; 

    public function __construct()
    {
        $this->userAccount = new UserAccount();
    }

    public function searchUsers(string $searchInfo): array
    {
        $allUsers = $this->userAccount->searchUsers($searchInfo);

        return $allUsers;
    }

}

?>