<?php
require_once "../entity/userAccount.php";

class SuspendUserAccountController
{
    private UserAccount $userAccount; 

    public function __construct()
    {
        $this->userAccount = new UserAccount();
    }

    public function suspendUser(string $username)
    {
        $flag = $this->userAccount->suspendUser($username);

        return $flag;
    }

}

?>