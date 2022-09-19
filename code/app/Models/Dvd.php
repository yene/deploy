<?php

namespace App\Models;

use App\Validators\MustBeANumber;
use App\Validators\MustNotBeEmpty;

class Dvd extends Product
{

    public function setAttributes(array $data)
    {
        //echo "hello from set attributes";
        //exit;
        $this->attributes = json_encode(["size" => $data['size'] . " MB"]);
    }

    public function validationRules()
    {

        $commonRules = parent::validationRules();

        $dvdSpecificRules = [
            'size' => [
                new MustNotBeEmpty(),
                new MustBeANumber()
            ]
        ];
        // echo "specific rules ";
        // print_r($dvdSpecificRules);
        // echo "merge ";

        // print_r(array_merge($commonRules, $dvdSpecificRules));

        return array_merge($commonRules, $dvdSpecificRules);
    }
}
