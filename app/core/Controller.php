<?php

class Controller extends Application
{


    public function __construct()
    {
        $this->request = new Input();
    }

    public function jsonResponse($resp = "", $code, $success = null)
    {
        header("Acces-Control-Alow-Origin: " . ACCESS_CONTROL_ORIGIN);
        header("Content-Type: application/json; charset=UTF-8");
        http_response_code($code);
        if (isset($success)) {
            echo json_encode(["message" => $resp, "success" => $success]);
        } elseif ($resp !== "") {
            echo json_encode($resp);
        }
        exit;
    }
}
