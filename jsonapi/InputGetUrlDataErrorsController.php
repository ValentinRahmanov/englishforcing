<?php

namespace Controller;

class InputGetUrlDataErrorsController extends Exception
{
    function __construct($message = null, $code = null, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function serviceWrongParameterInUrl() : void
    {
        print_r('Опечатка в названии, использованном в url или такого категории не существует!');
    }

    public function replyIfTypePOST() : void
    {
        print_r('Опечатка в названии, использованном в url или такого категории не существует!');
    }
}
