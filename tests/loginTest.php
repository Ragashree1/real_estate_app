<?php
require_once __DIR__ . "\..\controller\loginController.php";

class LoginTest extends \PHPUnit\Framework\TestCase {

    public function testAdminCanLoginWithCorrectCredentials()
    {
        $loginController = new LoginController();
        $loginInfo = [
            'username' => 'admin001',
            'password' => 'password123',
            'profile' => 'admin'
        ];

        $this->assertEquals($loginController->login($loginInfo), true);
    }

    public function testAdminCannotLoginWithWrongCredentials()
    {
        $loginController = new LoginController();
        $loginInfo = [
            'username' => 'admin001',
            'password' => 'pass',
            'profile' => 'admin'
        ];

        $this->assertEquals($loginController->login($loginInfo), false);
    }

    public function testAgentCanLoginWithCorrectCredentials()
    {
        $loginController = new LoginController();
        $loginInfo = [
            'username' => 'agent001',
            'password' => 'password123',
            'profile' => 'agent'
        ];

        $this->assertEquals($loginController->login($loginInfo), true);
    }

    public function testAgentCannotLoginWithWrongCredentials()
    {
        $loginController = new LoginController();
        $loginInfo = [
            'username' => 'agent001',
            'password' => 'pass',
            'profile' => 'agent'
        ];

        $this->assertEquals($loginController->login($loginInfo), false);
    }

    public function testSellerCanLoginWithCorrectCredentials()
    {
        $loginController = new LoginController();
        $loginInfo = [
            'username' => 'seller001',
            'password' => 'password123',
            'profile' => 'seller'
        ];
        $this->assertEquals($loginController->login($loginInfo), true);
    }

    public function testSellerCannotLoginWithWrongCredentials()
    {
        $loginController = new LoginController();
        $loginInfo = [
            'username' => 'seller001',
            'password' => 'pass',
            'profile' => 'seller'
        ];

        $this->assertEquals($loginController->login($loginInfo), false);
    }

    public function testBuyerCanLoginWithCorrectCredentials()
    {
        $loginController = new LoginController();
        $loginInfo = [
            'username' => 'buyer001',
            'password' => 'password123',
            'profile' => 'buyer'
        ];
        $this->assertEquals($loginController->login($loginInfo), true);
    }

    public function testBuyerCannotLoginWithWrongCredentials()
    {
        $loginController = new LoginController();
        $loginInfo = [
            'username' => 'buyer001',
            'password' => 'pass',
            'profile' => 'buyer'
        ];

        $this->assertEquals($loginController->login($loginInfo), false);
    }
}