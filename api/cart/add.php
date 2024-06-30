<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['product_id'], $_POST['quantity'])) {
        $productId = $_POST['product_id'];
        $quantity = $_POST['quantity'];
        addToCart($productId, $quantity);
        echo json_encode(['status' => 'success', 'message' => 'Product added to cart', 'id' => $productId, 'quantity' => $quantity]);
        }
    else{
        echo json_encode(["status" => "failed", "message" => "missing product_id and/or quantity"]);
    }
}

else{
    echo json_encode(["message" => "only POST enabled here"]);
}

function addToCart($productId, $quantity)
{
    // Ha még nincs kosár tömb a munkamenetben, inicializáljuk
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    // Ha a termék már szerepel a kosárban, növeljük a mennyiségét
    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId] += $quantity;
    } else {
        // Ellenkező esetben hozzáadjuk a terméket a kosárhoz
        $_SESSION['cart'][$productId] = $quantity;
    }

    // Kosárban lévő termékek darabszámának összesítése
    $_SESSION['cartTotal'] = array_sum($_SESSION['cart']);

    return json_encode(["message" => "Item $productId addedd successfully"]);
}