<?php

class Router
{


    public static function rout($url)
    {
        if (!isset($url[0])) {
            include(ROOT . DS . "login.php");
        } elseif (isset($url[0]) && $url[0] != 'app') {

            require_once(ROOT . DS . $url[0] . ".php");
        } elseif (isset($url[0]) && $url[0] == 'app') {

            array_shift($url);
            $controller_name = ucwords($url[0]) . "Controller";

            array_shift($url);
            if (isset($url[0]) && isset($url[0]) != '') {
                $action = $url[0] . "Action";

                array_shift($url);
                $queryParams = $url;

                $dispatch = new $controller_name();
                if (method_exists($controller_name, $action)) {
                    call_user_func_array([$dispatch, $action], $queryParams);
                } else {
                    die('That method does not exists in the controller \"' . $controller_name . '\"');
                }
            }
        }
    }

    public static function redirect($location = null)
    {
        if ($location) {
            if (is_numeric($location)) {
                switch ($location) {
                    case 404:
                        header('HTTP/1.0 404 Not Found');
                        include 'includes/errors/404.php';
                        exit;
                        break;
                }
            }
            header('Location:' . $location);
            exit();
        }
    }
}
