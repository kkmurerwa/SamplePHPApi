<?php
// Set required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// Import required files
include_once '../config/database.php';
include_once '../objects/category.php';

// Instantiate db
$database = new Database();
$db = $database->getConnection();

// Instantiate object
$category = new Category($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// Check if any field in input data is empty
if(
    !empty($data->name) &&
    !empty($data->description)
){
  
    // set product property values
    $category->name = $data->name;
    $category->description = $data->description;
    $category->created = date('Y-m-d H:i:s');
    $category->modified = date('Y-m-d H:i:s');
  
    // create the product
    if($category->create()){
  
        // set response code - 201 created
        http_response_code(201);
  
        // tell the user
        echo json_encode(array("message" => "Category was created successfully."));
    }
  
    // if unable to create the product, tell the user
    else{
  
        // set response code - 503 service unavailable
        http_response_code(503);
  
        // tell the user
        echo json_encode(array("message" => "Unable to create category."));
    }
}
  
// tell the user data is incomplete
else{
  
    // set response code - 400 bad request
    http_response_code(400);
  
    // tell the user
    echo json_encode(array("message" => "Unable to create category. Please enter all the required fields."));
}

?>