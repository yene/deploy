<?php

namespace App\Models;

use App\Validators\MustBeANumber;
use App\Validators\MustNotBeEmpty;

class Book extends Product
{
    //validation rules, what do you mean by that? I mean why do we need to do that again, just for the attributes?
    //in the Product class we did not validate size, weight and stuff. Because that should be done  in the child classes where they
    //appear //yeah yeah, so we validate here attributes and re validate the rest or just validate attributes? sorry I am not sure
    //not its okay, we are not going to revalidate. We are going to call the validator based on the type itself
    //so if its a book we will use validation from the Book class. We will override the rules fulction here, 
    //but we will also merge the parent class's validations here so that we wouldnt need to repeat  d

    //shall I demo? Or would you like to give it a go?
    //so one thing is we will introduce .. what is it, which one does Book get haha. is  it weight?
    // I would like to have a go.. just 5 min but I need to think about it.... sorry
    // yeah yeah no worries you trying is better 
    //ok
    //so... I write a little plan
    //data gets from frontend, then into product controller then into validation




    //so at the moment we are re validating 
    //but the main point here is attributes right? Yeah maybe like this

    public function setAttributes(array $data)
    {

        // echo "this is data before adding attributes";
        // print_r($data);

        $this->attributes = json_encode(["weight" => $data['weight'] . " KG"]);

        // echo "this is data after adding attributes: ";
        // print_r($this->attributes);
        //exit;
    }

    public function validationRules()
    {

        $commonRules = parent::validationRules(); //we need to assign it to a variable to use the returned array. 

        $bookSpecificRules = [
            'weight' => [
                new MustNotBeEmpty(),
                new MustBeANumber()
            ]
        ];

        // echo "specific rules ";
        // print_r($bookSpecificRules);
        // echo "merge ";

        //print_r(array_merge($commonRules, $bookSpecificRules));
        //exit;

        //return [...$commonRules, ...$bookSpecificRules];
        return array_merge($commonRules, $bookSpecificRules); //more readable 

    }
}
