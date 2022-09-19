<?php
//bridge design pattern
namespace App\Database; 

use PDO;
use App\Database\Connection;

abstract class QueryBuilder {

    protected $db = null;
    protected $wheres = [];
    protected $bindings = [];

    abstract public function table();

    public function __construct() {
        $this->db = (new Connection())->getInstance();
    }

    public function fetchAll(){
        return $this->execute()->fetchAll(PDO::FETCH_OBJ);
    }

    public function fetchOne(){
        return $this->execute()->fetch(PDO::FETCH_OBJ);
    }

    // public function select(){}
    public function where($columnName, $operator, $value){
        $this->wheres[] = "$columnName $operator :$columnName";
        $this->bindings[":$columnName"] = $value; 
        return $this;
    }


    public function execute(){

        $wheres = count($this->wheres) > 0 ? implode(' AND ', $this->wheres) : null;


        $query = "SELECT * FROM {$this->table()}";

        if( ! empty($this->wheres) ){
            $query .= " WHERE $wheres";
        }

        $query .= ";"; 

        $stmt = $this->db->prepare($query);
        $stmt = $this->bindParams($stmt);
        $stmt->execute();
        return $stmt;

    }

    public function bindParams($statement){
        if( ! empty($this->wheres) ){
            foreach( $this->bindings as $column => $value ){
                $statement->bindParam($column, $value);
            }
        }
        return $statement;
    }

    // public function test()
    // {
    //     var_dump(get_called_class());
    //     var_dump(get_class_vars(get_called_class()));
    // }

} 


