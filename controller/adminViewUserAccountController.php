<?php
require_once "../entity/userAccount.php";

class AdminViewUserAccountController
{
    private UserAccount $userAccount; 

    public function __construct()
    {
        $this->userAccount = new UserAccount();
    }

    public function getAccounts(): array
    {
        $allUsers = $this->userAccount->getAccounts();

        return $allUsers;
    }

}

?>