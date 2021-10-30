<?php

class Products
{
    private $_db,
        $_data;

    public function __construct()
    {
        $this->_db = DB::getInstance();
    }

    public function create($fields)
    {
        if (!$this->_db->insert("products", $fields)) {
            throw new Exception('There was a problem with creating your product.');
        }
    }

    public function patch($id, $fields = "", $values = [])
    {
        if (!$this->_db->update("products", $id, $fields, $values)) {
            return false;
        } else {
            return true;
        }
    }

    public function delete($id)
    {
        if (!$this->_db->delete("products", ["id", "=", $id])) {
            return false;
        } else {
            return true;
        }
    }

    public function getById($id = null)
    {
        if ($id) {
            $data = $this->_db->get('products', ['id', '=', $id]);

            if ($data->count()) {
                $this->_data = $data->first();
                return $this->_data;
            }
        }
        return false;
    }

    public function getAll()
    {
        $data = $this->_db->get("products");
        if ($data != []) {
            $this->_data = $data;
            return $this->_data;
        }
        return $data;
    }
}
