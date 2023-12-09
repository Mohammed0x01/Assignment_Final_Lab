<?php

Class Book{
    private $id;
    private $title;
    private $link;
    private $dateAdded;
    private $done = false;
    private $dbConnection;
    private $dbTable = 'bookmarks';


    public function __construct($dbConnection){
        $this->dbConnection = $dbConnection;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }


    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getLink() {
        return $this->link;
    }

    public function setLink($link) {
        $this->link = $link;
    }

    public function getDateAdded() {
        return $this->dateAdded;
    }

    public function setDateAdded($dateAdded) {
        $this->dateAdded = $dateAdded;
    }

    public function getDone() {
        return $this->done;
    }

    public function setDone($done) {
        $this->done = $done;
    }

    public function create (){
        $query = 'INSERT INTO ' . $this->dbTable . ' (title, link, date_added, done) VALUES (:titleName, :linkName, now(), false);';
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':titleName', $this->title);
        $stmt->bindParam(':linkName', $this->link);
        
        if ($stmt->execute()){
            return true;
        }
        
        printf('Error: %s', $stmt->error);
        return false;
    }
    

    public function readOne(){
        $query = 'SELECT * FROM '.$this->dbTable.' WHERE id=:id';
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':id', $this->id);
        //row count more than 0
        if($stmt->execute() && $stmt->rowCount()==1){
            $result = $stmt->fetch(PDO::FETCH_OBJ);
            $this->id = $result->id;
            $this->title= $result->title;
            $this->link= $result->link;
            $this->dateAdded = $result->date_added;
            $this->done= $result->done;
            return true;
        }
        return false;
    }

    public function readAll(){
        $query = 'SELECT * FROM '.$this->dbTable.' WHERE done = false';
        $stmt = $this->dbConnection->prepare($query);
        //row count more than 0
        if($stmt->execute() && $stmt->rowCount() > 0){
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return [];
    }

    public function update(){
        $query = 'UPDATE '.$this->dbTable.' SET done=:done WHERE id=:id';
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':done', $this->done);
        $stmt->bindParam(':id', $this->id);
        if($stmt->execute() && $stmt->rowCount()==1){
            return true;
        }
        return false;
    }

    public function delete(){
        $query = 'DELETE FROM '.$this->dbTable.' WHERE id=:id';
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':id', $this->id);
        if($stmt->execute() && $stmt->rowCount()==1){
            return true;
        }
        return false;
    }



}