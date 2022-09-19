<?php

//check interface vs abstract

namespace App\Models;

use PDO;
use App\Database\QueryBuilder; //this part we need.  sure...
use App\Database\Connection;
use App\Validators\MustBeANumber;
use App\Validators\MustBeUnique;
use App\Validators\MustNotBeEmpty;

// class Product extends QueryBuilder {

//     public function table(){
//         return "products";
//     }

// $queryAll = new Product();
// echo "hello";
// var_dump(get_object_vars($queryAll)); 

// $test = new Sub();
// $test->test();

// $queryAll->test();

class Product
{

    private $db;
    protected $table = 'products';
    public $columns = [];

    public function __construct()
    {
        $this->db = (new Connection())->getInstance();
    }

    public function validationRules()
    {
        $rules = [
            'sku' => [
                new MustBeUnique(),
                new MustNotBeEmpty(),
                new MustBeANumber()

            ],
            'price' => [
                new MustNotBeEmpty(),
                new MustBeANumber() //$23.5 cents 235 chance to lose precision 
            ],
            'name' => [
                new MustNotBeEmpty(),
            ],

        ];
        return $rules;
    }

    /**
     * sdfsdfsdf
     * sdfsdf
     * 
     * sdfsdf
     */
    public function getColumns()
    {
        return $this->columns;
    }

    public function __get($key)
    {
        return $this->columns[$key];
    }

    public function __set($key, $value)
    {
        $this->columns[$key] = $value;
    }

    public function readAll()
    {
        $query = 'SELECT * FROM ' . $this->table . ' ORDER BY id ';

        $stmt = $this->db->prepare($query);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function readOne($productId)
    {

        $query = 'SELECT * FROM ' . $this->table . ' WHERE id = :id';

        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':id', $productId);

        $stmt->execute();

        $object = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->columns = $object;

        //return $this->getColumns();
        return $this;
    }

    public function readWhere($column, $value)
    {

        $query = 'SELECT * FROM ' . $this->table . " WHERE $column = :$column";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":$column", $value);
        $stmt->execute();
        $object = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->columns = $object;

        //return $this->getColumns();
        return $this;
    }


    public function update()
    {
        //$query = 'UPDATE ' . $this->table . ' SET name = :name  WHERE id = :id';
        $query = $this->buildUpdateQuery();


        //print_r($query);

        // echo "ID is : ".$this->id;

        $stmt = $this->db->prepare($query);



        return $stmt->execute($this->columns);
        //yesorry it is already there... yah but it has to be $this->c/ you have a var dump inside build queryol
        //ok... thankssss
    }




    public function create()
    {

        $query = $this->buildInsertQuery();


        $stmt = $this->db->prepare($query);

        if ($stmt->execute($this->columns)) {
            $this->id = $this->db->lastInsertId();
            return $this;
        }
    }

    public function delete($id)
    {
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            return true;
        }

        print_r($stmt->errorInfo());

        return false;
    }

    // private function bindParams($statement)
    // {


    //     foreach ($this->columns as $value) {
    //         $statement->bindParam($value);
    //     }
    //     return $statement;
    // }

    private function buildUpdateQuery()
    {



        $columns = array_keys($this->columns);
        // echo "this is columns";
        // print_r($this->columns);
        $accumulatorInit = [];


        $preparedCols = array_reduce($columns, function ($accumulator, $column) {
            if ($column === "id") {
                return $accumulator; //retun accumulator as it is
            }

            $accumulator[] = "$column=:$column";

            return $accumulator;
        }, $accumulatorInit);

        echo "this is prepared columns after reduce";
        print_r($preparedCols);
        //exit;

        $columnsAndParamsString = implode(", ", $preparedCols); //I am expecting to see a string after this..


        return "UPDATE $this->table SET  $columnsAndParamsString WHERE id = :id";
    }

    private function buildInsertQuery()
    {
        // echo "this is columns array";
        // print_r($this->columns);

        $columns = array_keys($this->columns);


        // echo "<pre>";
        // echo "this is colums with array key method";
        // print_r($columns);
        // echo "</pre>";


        $accumulatorInit = [
            "cols" => [],
            "params" => [],
        ];

        $preparedCols = array_reduce($columns, function ($accumulator, $column) {
            array_push($accumulator["cols"], $column);
            array_push($accumulator["params"], ":$column");
            return $accumulator;
        }, $accumulatorInit);
        // echo "this is after reduce";
        // print_r($preparedCols);

        $preparedColNames = implode(", ", $preparedCols["cols"]);
        $preparedBindParams = implode(", ", $preparedCols["params"]);

        return "INSERT INTO $this->table ( $preparedColNames ) VALUES ( $preparedBindParams )";
    }
}
