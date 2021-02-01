<?php 
class Category {
    // database connection and table name
    private $conn;
    private $table_name = "categories";
  
    // object properties
    public $id;
    public $name;
    public $description;
    public $created_date;
    public $modified_date;
  
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }


// read categories
function read(){
  
    // select all query
    $query = "SELECT
                q.id, q.name, q.description, q.created, q.modified
                FROM
                    " . $this->table_name . " q
                ORDER BY
                    q.created DESC";
  
    // prepare query statement
    $stmt = $this->conn->prepare($query);
  
    // execute query
    $stmt->execute();
  
    return $stmt;
}
}
?>