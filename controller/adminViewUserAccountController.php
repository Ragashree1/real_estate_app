<?php
require_once "../entity/userAccount.php";

class AdminViewUserAccountController
{
    private UserAccount $userAccount; 

    public function __construct()
    {
        $this->userAccount = new UserAccount();
    }

    public function getUsers(): array
    {
        $allUsers = $this->userAccount->getUsers();

        return $allUsers;
    }

}

?>