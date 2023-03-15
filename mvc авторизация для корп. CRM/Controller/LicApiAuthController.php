<?php

namespace Controller;

class LicApiAuthController
{
    private array $errorCodesInApiArr = [1, 3, 4, 10, 14, 17];

    public function login($log, $pass, $pCode): object
    {
        $data = ["user_name" => $log, "user_pass" => $pass, "product_code" => $pCode];
        $ch = curl_init('https://auth.1clicom.ru/auth/login/');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $result = json_decode(curl_exec($ch));
        $curlErr = curl_error($ch);
        if ($result->request->code === 0) {
            return $result;
        } else {
            return $this->workWithErrors($curlErr, $result->request->code);
        }
    }

    private function workWithErrors($curlErr, $respCode): object
    {
        if (!empty($curlErr)) {
            throw new ErrorController($curlErr,112);
        } else {
            if (in_array($respCode, $this->errorCodesInApiArr)) {
                throw new ErrorController('Неверные логин, пароль или код продукта!', $respCode);
            } else {
                throw new ErrorController('Api не отвечает!', $respCode);
            }
        }


    }
}
