<?php

namespace Controller;

use View\View;

class HomePageController
{
    public function showHomePage() : void
    {
        if(!isset($_COOKIE['auth'])) {
            View::renderHTML('headerWithButton');
            View::renderHTML('main');
            View::renderHTML('footer');
        } else {
            View::renderHTML('headerWithButton');
            View::renderHTML('main');
            View::renderHTML('footer');
            echo '<script>alert("Вы авторизованы!");</script>';
        }
    }

    public function show404() : void
    {
        print_r('доходит');
        //View::renderHTML('404-template');
        include('../View/404-template.php');
    }
}