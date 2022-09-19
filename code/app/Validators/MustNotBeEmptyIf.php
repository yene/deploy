<?php

// class MustNotBeEmptyIf
// {

//     public function __construct(protected $field, protected $condition)
//     {
//         if (!is_bool($this->condition)) {
//             throw new Exception("Second condition must be a boolean value");
//         }
//     }

//     public function __invoke()
//     {
//         if ($this->condition == false) {
//             return;
//         }

//         if (getRequest($this->field) != "") //use also REQUEST 
//         {
//             return getRequest($this->field);
//         }
//         throw new Exception("$this->field must not be empty", 422);
//     }
// }
