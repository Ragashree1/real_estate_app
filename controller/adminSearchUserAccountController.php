<?php
require_once "../entity/userAccount.php";

class AdminSearchUserAccountController
{
    private UserAccount $userAccount; 

    public function __construct()
    {
        $this->userAccount = new UserAccount();
    }

    public function searchAccounts(string $searchInfo): array
    {
        $allUsers = $this->userAccount->searchAccounts($searchInfo);

        return $allUsers;
    }

}

?>