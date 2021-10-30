<?php

class Input
{
    public static function sanitize($value)
    {
        return htmlentities($value, ENT_QUOTES, "UTF_8");
    }

    public static function get($value)
    {
        if (isset($_POST[$value])) {
            return self::sanitize($_POST[$value]);
        } elseif (isset($_GET[$value])) {
            return self::sanitize($_GET[$value]);
        }
    }

    public function isPost()
    {
        return $this->getRequestMethod() === 'POST';
    }

    public function isOptions()
    {
        return $this->getRequestMethod() === 'OPTIONS';
    }

    public function isPatch()
    {
        return $this->getRequestMethod() === 'PATCH';
    }

    public function isDelete()
    {
        return $this->getRequestMethod() === 'DELETE';
    }

    public function isGet()
    {
        return $this->getRequestMethod() === 'GET';
    }

    public function getRequestMethod()
    {
        return strtoupper($_SERVER['REQUEST_METHOD']);
    }
}
