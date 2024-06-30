<?php
require '../src/models/user.php'; // Include the User model
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require_once '../config/database.php';
require_once '../src/models/Product.php';

$database = new Database();
$db = $database->getConnection();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = new user($db);
        $result = $user->login($email, $password);

        if ($result) {
            $response = ['status' => 'success', 'message' => 'Login successful'];
        } else {
            $response = ['status' => 'error', 'message' => 'Invalid email or password'];
        }

        header('Content-Type: application/json');
        echo json_encode($response);

    }
    else{
        echo json_encode(["status" => "error", "message" => "only POST method is accepted"]);
    }