<?php
require_once "../entity/userAccount.php";

class DeleteUserAccountController
{
    private UserAccount $userAccount; 

    public function __construct()
    {
        $this->userAccount = new UserAccount();
    }

    public function deleteUser(string $username)
    {
        $flag = $this->userAccount->deleteUser($username);

        return $flag;
    }

}

?>