<?php
require_once __DIR__.'/../vendor/autoload.php'; // MongoDB PHP Library

class Database {
    private $db;

    public function getConnection() {
        $client = new MongoDB\Client("mongodb+srv://myAtlasDBUser:admin@myatlasclusteredu.2ko1ud9.mongodb.net/?retryWrites=true&w=majority&appName=myAtlasClusterEDU");
        $this->db = $client->webshop; 
        return $this->db;
    }
}
?>
