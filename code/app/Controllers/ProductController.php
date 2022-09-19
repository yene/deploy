<?php

namespace App\Controllers;

use App\Models\Book;
use App\Models\Dvd;
use App\Models\Furniture;
use App\Models\Product;
use App\Validators\MustNotBeEmpty;
use App\Validators\Validator;

class ProductController
{

    public function index()
    {

        $products = (new Product())->readAll();

        return json_encode(["data" => $products], JSON_PRETTY_PRINT);
    }

    public function store()
    {
        //planning
        $data = json_decode(file_get_contents('php://input'), true);
        //THIS IS NOT FINAL, JUST LAYING IT OUT
        $productTypeRule = [
            'type' => [
                new MustNotBeEmpty(),
            ]
        ];
        $x = Validator::validate($data, $productTypeRule);

        $validators = [
            'Book' => new Book(),
            'Furniture' => new Furniture(),
            'DVD' => new Dvd(),
        ];

        $product = $validators[$data['type']];

        $rules = $product->validationRules();

        $validatedData = Validator::validate($data, $rules);
        //end planning

        $product->name = $data['name'];
        $product->SKU = $data['sku'];
        $product->price = $data['price'];
        $product->type = $data['type'];
        $product->setAttributes($data);
        $product = $product->create();
        header('Content-type: application/json');
        return json_encode(["data" => $product->getColumns()], JSON_PRETTY_PRINT);
    }

    public function show()
    {
        $product = (new Product())->readOne(2);
        http_response_code(200);
        return json_encode(["data" => $product], JSON_PRETTY_PRINT);
    }

    public function update($id)
    {
        $product = (new Product())->readOne($id);
        $product->name = "Overridden Name333";
        $product->update();
        http_response_code(204);
        return json_encode("updated", JSON_PRETTY_PRINT);
    }

    public function delete($id)
    {
        $product = (new Product())->delete($id);
        http_response_code(200);
        return json_encode(["data" => $product], JSON_PRETTY_PRINT);
    }

    public function test()
    {
        var_dump(get_called_class());
        var_dump(get_class_vars(get_called_class()));
    }
}

// $test = new ProductController();
// $echo $test->test();
