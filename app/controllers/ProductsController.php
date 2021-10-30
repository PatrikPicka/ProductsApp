<?php

class ProductsController extends Controller
{

    private $_products, $_request;

    public function __construct()
    {
        $this->_products = new Products();
        $this->_request = new Input();

        //when live uncoment this for check if the user is authorized
        $user = new User();
        if (!$user->isLoggedIn()) {
            //unauthorized access denied

            return $this->jsonResponse("You have to be logged in to get access to the products.", 401, false);
            //Router::redirect("../../login");
        }
    }

    public function productsAction($id = null)
    {
        //options = preflight request which has to be successful for cross side requests
        if ($this->_request->isOptions()) {
            return $this->jsonResponse("", 200);
        } else {
            if ($id === null) {
                if ($this->_request->isGet()) {
                    $products = $this->_products->getAll();
                    return $this->jsonResponse($products, 200);
                } elseif ($this->_request->isPost()) {

                    $payload = json_decode(file_get_contents("php://input"));

                    $error = null;
                    try {
                        $this->_products->create([
                            "name" => $payload->name,
                            "description" => $payload->description
                        ]);
                    } catch (Exception $e) {
                        $error = $e->getMessage();
                    }
                    if (!$error) {
                        return $this->jsonResponse("Successfully created.", 201);
                    } else {
                        return $this->jsonResponse("There was a problem creating your product.", 500);
                    }
                } else {
                    return $this->jsonResponse("No route found for method:" . $_SERVER['REQUEST_METHOD'], 500);
                }
            } elseif (isset($id)) {
                //check if its a get - post - patch - delete request
                if ($this->_request->isGet()) {
                    $product = $this->_products->getById($id);
                    return $this->jsonResponse($product, 200);
                } elseif ($this->_request->isPatch()) {
                    $payload = json_decode(file_get_contents("php://input"));

                    $fields = "";
                    $values = [];
                    if (isset($payload->name)) {
                        $fields .= "name,";
                        $values[] = $payload->name;
                    }
                    if (isset($payload->description)) {
                        $fields .= "description,";
                        $values[] = $payload->description;
                    }

                    $fieldsTrimmed = rtrim($fields, ",");

                    if ($this->_products->patch($id, $fieldsTrimmed, $values)) {
                        return $this->jsonResponse("Successfully updated.", 200);
                    } else {
                        return $this->jsonResponse("Something went wrong...", 500);
                    }
                } elseif ($this->_request->isDelete()) {
                    if ($this->_products->delete($id)) {
                        return $this->jsonResponse("product deleted", 204);
                    } else {
                        return $this->jsonResponse("Something wen wrong...", 500);
                    }
                } else {
                    return $this->jsonResponse("No route found for method: " . $_SERVER['REQUEST_METHOD'], 500);
                }
            }
        }
    }
}
