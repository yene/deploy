<?php

namespace App\Models;

use App\Validators\MustBeANumber;
use App\Validators\MustNotBeEmpty;

class Furniture extends Product
{

    public function setAttributes(array $data)
    {
        $this->attributes = json_encode(
            [
                "height" => $data['height'] . " cm",
                "width" => $data['width'] . " cm",
                "length" => $data['length'] . " cm"
            ]
        );
    }

    public function validationRules()
    {
        $commonRules = parent::validationRules();

        $furnitureSpecificRules = [
            'height' => [
                new MustNotBeEmpty(),
                new MustBeANumber()
            ],
            'width' => [
                new MustNotBeEmpty(),
                new MustBeANumber()
            ],
            'length' => [
                new MustNotBeEmpty(),
                new MustBeANumber()
            ]
        ];

        return array_merge($commonRules, $furnitureSpecificRules);
    }
}
