<?php

//check HTTP method used not GET
if($_SERVER['REQUEST_METHOD']!=='GET'){
    header('Allow: GET');
    http_response_code(405);
    echo json_encode(
        array('message' =>'Method not allowed')
    );
    return;
}

//set HTTP response header
header('Access-Control-Allow-Origin: *');
header('Content-Type-: Application/json');
header('Access-Control-Allow-Method: GET');

include_once '../db/Database.php';
include_once '../models/Book.php';

//Instantiate a database object and connect
$database = new Database();
$dbConnection = $database->connect();

//Instatiate a Todo object
$todo = new Book($dbConnection);

// read all todo items
$result = $todo->readAll();
if(! empty($result)){
    echo json_encode($result);
}
else{
    echo json_encode (
        array('message' => 'no todo items were found')
    );
}
