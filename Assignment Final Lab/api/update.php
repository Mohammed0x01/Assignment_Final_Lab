<?php

//check HTTP method used not GET
if($_SERVER['REQUEST_METHOD']!=='PUT'){
    header('Allow: PUT');
    http_response_code(405);
    echo json_encode(
        array('message' =>'Method not allowed')
    );
    return;
}

//set HTTP response header
header('Access-Control-Allow-Origin: *');
header('Content-Type-: Application/json');
header('Access-Control-Allow-Method: PUT');

include_once '../db/Database.php';
include_once '../models/Book.php';

//Instantiate a database object and connect
$database = new Database();
$dbConnection = $database->connect();

//Instatiate a Todo object
$todo = new Book($dbConnection);

// GET the http put request JSON body
$data = json_decode(file_get_contents('php://input'));

if(!$data || !$data->id || !$data->done){
    http_response_code(422);
    echo json_encode(
        array('message' => 'ERROR: Missing required parameters id and done in the JSON body')
    );
    return;
}

//update the item
$todo->setId($data->id);
$todo->setDone($data->done);
if($todo->update()){
    echo json_encode(
        array('message' => 'The todo item was updated ')
    );
}
else{
    echo json_encode(
        array('message' => 'The todo item was not updated ')
    );
}

