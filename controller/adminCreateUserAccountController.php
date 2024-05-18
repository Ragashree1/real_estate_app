<?php
require_once "../entity/userAccount.php";

class AdminCreateUserAccountController
{
    private UserAccount $userAccount; 

    public function __construct()
    {
        $this->userAccount = new UserAccount();
    }

    public function createAccount(array $userDetails) : bool
    {
        $status = $this->userAccount->createAccount($userDetails);
        return $status;
    }
}

?>