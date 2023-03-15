<?php

namespace View;

class View
{
    public static function renderHTML($templateName) : void
    {
        ob_start();

        if($templateName !== 'main') {
            include('../View/' . $templateName . '.php');
        } else {
            include('../View/main/' . $templateName . '.php');
        }

        $buffer = ob_get_contents();
        ob_end_clean();
        echo $buffer;
    }
}







