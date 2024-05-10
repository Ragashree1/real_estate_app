<?php
require_once "../entity/userAccount.php";

class AdminUpdateUserAccountController
{
    private UserAccount $userAccount; 

    public function __construct()
    {
        $this->userAccount = new UserAccount();
    }

    public function updateUser(array $userDetails) : bool
    {
        $status = $this->userAccount->updateUser($userDetails);
        return $status != null && $status != false;
    }
}

?>