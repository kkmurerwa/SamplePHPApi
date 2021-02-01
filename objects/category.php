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

// create product
function create(){
  
    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                name=:name, description=:description, created=:created, modified=:modified";
  
    // prepare query
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $this->name=htmlspecialchars(strip_tags($this->name));
    $this->description=htmlspecialchars(strip_tags($this->description));
  
    // bind values
    $stmt->bindParam(":name", $this->name);
    $stmt->bindParam(":description", $this->description);
    $stmt->bindParam(":created", $this->created);
    $stmt->bindParam(":modified", $this->modified);
  
    // execute query
    if($stmt->execute()){
        return true;
    }
  
    return false;
      
}

}
?>