<?php

require_once '../../config/database.php';
require_once '../../src/models/Product.php';

$database = new Database();
$db = $database->getConnection();
$product = new Product($db);


session_start();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
        echo json_encode([]); // Üres tömb visszaadása, ha nincs kosár
    } else {
        $cart = $_SESSION['cart'];
        $productIds = array_keys($cart);
        $cartItems = [];

        foreach ($productIds as $id) {
            $productDetail = $product->readOne($id);
            if ($productDetail) {
                $productDetail['id'] = $productDetail['_id'].'$oid';
                $productDetail['_quantity'] = $cart[$id];
                unset($productDetail['_id']);
                $cartItems[] = $productDetail;
            }
        }
        echo json_encode($cartItems); // Az összes terméket visszaadjuk JSON formátumban
    }
}
