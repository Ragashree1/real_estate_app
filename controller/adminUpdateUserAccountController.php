<?php
require_once "../entity/userAccount.php";

class AdminUpdateUserAccountController
{
    private UserAccount $userAccount; 

    public function __construct()
    {
        $this->userAccount = new UserAccount();
    }

    public function updateAccount(array $userDetails) : bool
    {
        $status = $this->userAccount->updateAccount($userDetails);
        return $status != null && $status != false;
    }
}

?>