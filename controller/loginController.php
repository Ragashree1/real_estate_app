<?php
require_once "../entity/userAccount.php";

class LoginController
{
    private UserAccount $account; 

    public function __construct()
    {
        $this->account = new UserAccount();
    }

    public function login(array $loginInfo): bool
    {
        $validated = $this->account->login($loginInfo);

        return $validated;
    }
}

?>