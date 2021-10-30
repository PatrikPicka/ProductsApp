<?php

class User
{
    private $_db,
        $_data,
        $_sessionName,
        $_isLoggedIn;
    //Construct zajišťuje přístup do databáze pomocí variable $_db
    public function __construct($user = null)
    {
        $this->_db = DB::getInstance();
        $this->_sessionName = SESSION_NAME;

        if (!$user) {
            if (Session::exists($this->_sessionName)) {
                $user = Session::get($this->_sessionName);

                if ($this->find($user)) {
                    $this->_isLoggedIn = true;
                } else {
                    $this->logout();
                }
            }
        } else {
            $this->find($user);
        }
    }

    public function create($fields)
    {
        if (!$this->_db->insert("users", $fields)) {
            throw new Exception('There was a problem creating an account.');
        }
    }

    public function find($user = null)
    {
        if ($user) {
            $field = (is_numeric($user)) ? 'id' : 'username';
            $data = $this->_db->get('users', array($field, '=', $user));

            if ($data->count()) {
                $this->_data = $data->first();
                return true;
            }
        }
        return false;
    }

    public function login($username = null, $password = null)
    {

        $user = $this->find($username);

        if ($user) {

            if (password_verify($password, $this->data()->password)) {
                Session::put($this->_sessionName, $this->data()->id);
                return true;
            }
        }
        return false;
    }

    public function logout()
    {
        Session::delete($this->_sessionName);
    }

    public function data()
    {
        return $this->_data;
    }
    public function isLoggedIn()
    {
        return $this->_isLoggedIn;
    }
}
