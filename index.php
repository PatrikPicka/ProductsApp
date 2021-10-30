<?php
session_start();
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__));

require_once(ROOT . DS . 'config' . DS . 'config.php');
//require_once(ROOT . DS . 'app' . DS . 'lib' . DS . 'helpers' . DS . 'functions.php');

function autoload($className)
{
    if (file_exists(ROOT . DS . "app" . DS . 'core' . DS . $className . '.php')) {
        require_once(ROOT . DS . "app" . DS . 'core' . DS . $className . '.php');
    } elseif (file_exists(ROOT . DS . 'app' . DS . 'controllers' . DS . $className . '.php')) {
        require_once(ROOT . DS . 'app' . DS . 'controllers' . DS . $className . '.php');
    }
}
spl_autoload_register('autoload');

$url = isset($_SERVER['PATH_INFO']) ? explode('/', ltrim($_SERVER['PATH_INFO'], '/')) : [];


//list of pages which are accessable only when user is logged in
$accessableOnlyWhenLoggedIn = ["products"];

$user = new User();
//check if the user has to be logged in to access the page
foreach ($accessableOnlyWhenLoggedIn as $page) {
    if ($url[0] === $page && !$user->isLoggedIn()) {
        Router::redirect("login");
    }
}

Router::rout($url);
