<?php 
// required header
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

    // include database and object files
include_once '../config/database.php';
include_once '../objects/category.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize object
$category = new Category($db);

// query products
$stmt = $category->read();
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){
  
    // products array
    $categories_arr = array();
  
    // retrieve our table contents
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        extract($row);
  
        $product_item = array(
            "id" => $id,
            "name" => $name,
            "description" => html_entity_decode($description),
            "date_created" => $created,
            "modified_date" => $modified
        );
  
        array_push($categories_arr, $product_item);
    }
  
    // set response code - 200 OK
    http_response_code(200);
  
    // show products data in json format
    echo json_encode($categories_arr);
} else{
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user no products found
    echo json_encode(
        array("message" => "No categories found.")
    );
}


?>