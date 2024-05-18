<?php
require_once "../entity/userAccount.php";

class AdminDeleteUserAccountController
{
    private UserAccount $userAccount; 

    public function __construct()
    {
        $this->userAccount = new UserAccount();
    }

    public function deleteAccount(string $username) :bool
    {
        $flag = $this->userAccount->deleteAccount($username);

        return $flag;
    }

}

?>