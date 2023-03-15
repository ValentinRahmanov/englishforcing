<?php

namespace Controller;

use Routing\Router;

class AuthController
{
    public object $licApi;

    function __construct()
    {
        $this->licApi = new LicApiAuthController();
    }

    public function auth(): void
    {
        try {
            $licResponse = $this->licApi->login($_POST['login'], $_POST['password'], $_POST['productCode']);
            setcookie("auth", $licResponse->data->SID, time() + 300);
            header('Location: /');
        } catch (ErrorController $e) {
            print_r($e->getMessage());
            ErrorController::warn($e->getCode(), $e->getMessage());
        }
    }

    public static function checkAuth(): bool
    {
        if (isset($_COOKIE['auth'])) {
            return true;
        } else {
            return false;
        }
    }
}
