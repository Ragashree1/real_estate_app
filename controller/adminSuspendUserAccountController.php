<?php
require_once "../entity/userAccount.php";

class AdminSuspendUserAccountController
{
    private UserAccount $userAccount; 

    public function __construct()
    {
        $this->userAccount = new UserAccount();
    }

    public function suspendAccount(string $username) : bool
    {
        $flag = $this->userAccount->suspendAccount($username);

        return $flag;
    }

}

?>