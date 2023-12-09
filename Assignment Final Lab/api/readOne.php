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

// get the http get request query parameter (e.g., ?id=140)
if(!isset($_GET['id'])){
    http_response_code(422);
    echo json_encode(
        array('message' => 'Error missing required query parameter id')
    );
    return;
}

//Read todo details
$todo->setId($_GET['id']);
if($todo->readOne()){
    $result = array(
        'id' => $todo->getId(),
        'title' => $todo->getTitle(),
        'link' => $todo->getLink(),
        'dateAdded' => $todo->getDateAdded(),
        'done' => $todo->getDone()
    );
    echo json_encode($result);
}
else{
    http_response_code(404);
    echo json_encode(
        array('message' => 'Error: no such todo item')
    );
}
