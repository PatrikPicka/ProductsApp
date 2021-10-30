<?php

class RegisterController extends Controller
{
    public function loginAction()
    {

        if ($this->request->isPost()) {

            $payload = json_decode(file_get_contents("php://input"));
            $username = $payload[0]->value;
            $password = $payload[1]->value;

            $user = new User();
            $login = $user->login($username, $password);
            if ($login) {
                return $this->jsonResponse("successfully logged in", 200, true);
            } else {
                return $this->jsonResponse("Loging in failed.", 500, false);
            }
        }
    }

    public function registerAction()
    {
        if ($this->request->isPost()) {
            $payload = json_decode(file_get_contents("php://input"));
            $username = $payload[0]->value;
            $password = $payload[1]->value;


            $user = new User();
            if (!$user->find($username)) {
                try {
                    $user->create([
                        "username" => $username,
                        "password" => password_hash($password, PASSWORD_DEFAULT)
                    ]);
                } catch (Exception $e) {
                    $error = $e->getMessage();
                }
                return $this->jsonResponse("Successfully registered.", 201, true);
            } else {
                return $this->jsonResponse("User already exists with these credentials." . $username, 500, false);
            }
        }
    }
    public function logoutAction()
    {
        if ($this->request->isPost()) {
            $user = new User();
            $user->logout();
            return $this->jsonResponse("Successfully logged out.", 200);
        }
    }
}
