<?php

namespace Controller;

use Throwable;
use View\View;

use \Exception;

class ErrorController extends Exception
{
    function __construct($message, $code, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static function warn($code, $message): void
    {
        $_ENV['code'] = $code;
        $_ENV['message'] = $message;

        View::renderHTML('warningMessage');
    }

    public static function show404() : void
    {
        View::renderHTML('404-template');
    }

    public static function informAboutMissedAuth() : void
    {
        View::renderHTML('missedAuthMessage');
    }
}
