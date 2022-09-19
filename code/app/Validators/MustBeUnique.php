<?php

// include_once '../config/database.php';

// $database = new Database();
// $db = $database->connect();

namespace App\Validators;

use App\Database\Connection;
use App\Models\Product;
use Exception;

class MustBeUnique
{


    public function __invoke($field, $data)
    {
        $sku = $data[$field];
        // $this->databaseConnect = $this->data->connect();
        $product = new Product();
        $product = $product->readWhere('sku', $sku);
        // print_r($product);
        //echo "get Columns array is following";
        //print_r($product->getColumns());


        if (empty($product->getColumns())) {
            // echo "this is empty";
            return $sku;
        } else {

            // echo "this is NOT empty";
            throw new Exception("$field must be unique", 422);
        }
        //exit;
    }
}
