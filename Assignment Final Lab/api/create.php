<?php

//check HTTP method used not POST
if($_SERVER['REQUEST_METHOD']!=='POST'){
    header('Allow: POST');
    http_response_code(405);
    echo json_encode(
        array('message' =>'Method not allowed')
    );
    return;
}

//set HTTP response header
header('Access-Control-Allow-Origin: *');
header('Content-Type-: Application/json');
header('Access-Control-Allow-Method: POST');

include_once '../db/Database.php';
include_once '../models/Book.php';

//Instantiate a database object and connect
$database = new Database();
$dbConnection = $database->connect();

//Instatiate a Todo object
$todo = new Book($dbConnection);

//get the HTTP post request json body (from postman)
$data = json_decode(file_get_contents('php://input'), true);

//if no task included in the json body, return an error
if(!$data || !isset($data['title']) || !isset($data['link']) ){
    http_response_code(422);
    echo json_encode(
        array('message' => 'Error missing required parameter task in the JSON body')
    );
    return;
}

//create a todo item
$todo->setTitle($data['title']);
$todo->setLink($data['link']);
if($todo->create()){
    echo json_encode(
        array('message' => 'a to do item was created')
    );
}else{
    echo json_encode(
        array('message' => 'Error: no to do item was created')
    );
}
