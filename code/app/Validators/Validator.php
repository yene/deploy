<?php

namespace App\Validators;

class Validator
{

    public static function validate(array $data, array $validationRules)
    {
        // foreach( $validationRules as $rule ){
        //     $rule();
        // }


        foreach ($validationRules as $field => $rules) {
            foreach ($rules as $rule) {
                $rule($field, $data); //calling the __invoke method in the rule class. 
            }
        }
    }
}
