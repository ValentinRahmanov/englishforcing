<?php

namespace Controller;

class DbErrorsController extends Exception
{
    function __construct($message = null, $code = null, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static function serviceDbErrors($massage, $code)
    {
        print_r('Ошибка подключения к базе данных, код ошибки: ' . $code . ', сообщение: ' . $massage);
    }
}

