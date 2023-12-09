<?php

//check HTTP method used not GET
if($_SERVER['REQUEST_METHOD']!=='DELETE'){
    header('Allow: DELETE');
    http_response_code(405);
    echo json_encode(
        array('message' =>'Method not allowed')
    );
    return;
}

//set HTTP response header
header('Access-Control-Allow-Origin: *');
header('Content-Type-: Application/json');
header('Access-Control-Allow-Method: DELETE');

include_once '../db/Database.php';
include_once '../models/Book.php';

//Instantiate a database object and connect
$database = new Database();
$dbConnection = $database->connect();

//Instatiate a Todo object
$todo = new Book($dbConnection);

// GET the http DELETE request JSON body
$data = json_decode(file_get_contents('php://input'));

if(!$data || !$data->id){
    http_response_code(422);
    echo json_encode(
        array('message' => 'ERROR: Missing required parameters id and done in the JSON body')
    );
    return;
}

//delete the item
$todo->setId($data->id);
if($todo->delete()){
    echo json_encode(
        array('message' => 'The todo item was delete ')
    );
}
else{
    echo json_encode(
        array('message' => 'The todo item was not deleted ')
    );
}

