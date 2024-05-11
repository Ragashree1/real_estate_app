<?php
session_start();
require_once __DIR__ . "\..\controller\loginController.php";

class LoginTest
{
    
    public function testAdminCanLogin()
    {
        $userAccount = new LoginController();
        $loginInfo = [
            'username' => 'admin001',
            'password' => 'password123',
            'profile' => 'admin'
        ];
        try{
            assert($userAccount->login($loginInfo) == true) ;
            echo "admin can login\n";
        }catch (Error $e){
            echo "admin login falied\n";
        }
    }

    public function testAgentCanLogin()
    {
        $userAccount = new LoginController();
        $loginInfo = [
            'username' => 'agent001',
            'password' => 'password123',
            'profile' => 'agent'
        ];
        try{
            assert($userAccount->login($loginInfo) == true);
            echo "agent can login\n";
        }catch (Error $e){
            echo "agent login falied\n";
        }
    }

    public function testSellerCanLogin()
    {
        $userAccount = new LoginController();
        $loginInfo = [
            'username' => 'seller001',
            'password' => 'password123',
            'profile' => 'seller'
        ];
        try{
            assert($userAccount->login($loginInfo) == true) ;
            echo "seller can login\n";
        }catch (Error $e){
            echo "seller login falied\n";
        }
    }

    public function testBuyerCanLogin()
    {
        $userAccount = new LoginController();
        $loginInfo = [
            'username' => 'buyer001',
            'password' => 'password123',
            'profile' => 'buyer'
        ];
        try{
            assert($userAccount->login($loginInfo) == true) ;
            echo "buyer can login\n";
        }catch (Error $e){
            echo "buyer login falied\n";
        }
    }
}

// Run the tests
$test = new LoginTest();
$test->testAdminCanLogin();
$test->testAgentCanLogin();
$test->testSellerCanLogin();
$test->testBuyerCanLogin();

?>
