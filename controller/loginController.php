<?php
require_once "../entity/userAccount.php";

class LoginController
{
    private UserAccount $account; 

    public function __construct()
    {
        $this->account = new UserAccount();
    }

    public function validateLogin(array $loginInfo): bool
    {
        $validated = $this->account->validateLogin($loginInfo);

        return $validated;
    }
}

?>