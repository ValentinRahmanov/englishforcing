<?php

class CorrectnessChecker
{

    private string $code;

    function __construct(string $code)
    {
        $this->code = $code;
    }

    public function checkCode() : bool
    {
        $i = 0;
        $openBracket = 0;
        $closeBracket = 0;

        while (!empty($this->code[$i])) {
            $this->code[$i] = '{' ? $openBracket += 1 : $openBracket += 0;
            $this->code[$i] = '}' ? $closeBracket += 1 : $closeBracket += 0;
            $i++;
        }

        if($openBracket == $closeBracket) {
            return true;
        } else {
            return false;
        }
    }
}