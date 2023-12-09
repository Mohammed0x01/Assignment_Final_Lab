<?php

class Database {
    private $dbHost;
    private $dbPort;
    private $dbName;
    private $dbUser;
    private $dbPassword;
    private $dbConnection;

    public function __construct(){
        // read db credentials as environment variables
        $this->dbHost = getenv('DB_HOST');
        $this->dbPort = getenv('DB_PORT');
        $this->dbName = getenv('DB_NAME');
        $this->dbUser = getenv('DB_USER');
        $this->dbPassword = getenv('DB_PASSWORD');

        // Check if any of the required environment variables are not set
        if (empty($this->dbHost) || empty($this->dbPort) || empty($this->dbName) || empty($this->dbUser) || empty($this->dbPassword)) {
            die("Error: One or more required database environment variables are not set.");
        }

    }

    public function connect(){
        try{
            $this->dbConnection = new PDO(
                'mysql:host=' . $this->dbHost . ';port=' . $this->dbPort . ';dbname=' . $this->dbName, $this->dbUser, $this->dbPassword
            );
            $this->dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $e){
            die('Connection Error: '  .   $e->getMessage());
        }
        return $this->dbConnection;
    }
}