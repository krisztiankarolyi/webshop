<?php
session_start();

if(!isset($_SESSION['cart'])) $_SESSION['cart'] = array();

if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    echo json_encode($_SESSION["cart"]);

}