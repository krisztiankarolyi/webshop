<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['product_id'], $_POST['quantity'])) {
        $productId = $_POST['product_id'];
        $quantity = (int) $_POST['quantity'];
        addToCart($productId, $quantity);

    } else {
        echo json_encode(["status" => "failed", "message" => "Missing product_id and/or quantity"]);
    }
} else {
    echo json_encode(["message" => "Only POST enabled here"]);
}

function addToCart($productId, $quantity) {
    // Ha még nincs kosár tömb a munkamenetben, inicializáljuk
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    $productId = str_replace("'", " ", $productId); $productId = str_replace("\$oid", " ", $productId);
    $productId = trim($productId);

    // Ha a termék már szerepel a kosárban, növeljük a mennyiségét (vagy csökkentjük, ha negatív a mennyiség)
    if (isset($_SESSION['cart'][$productId]))
    {
        $_SESSION['cart'][$productId] += $quantity;

        // Ha a mennyiség 0 vagy kevesebb lesz, eltávolítjuk a terméket a kosárból
        if ((int) $_SESSION['cart'][$productId] <= 0) {
            unset($_SESSION['cart'][$productId]);
            echo json_encode(["status" => "success", "message" => "Item removed from the cart", 'cartCount' => getCartCount()]);

            return;
        }
    }

    else
    {
        // Ellenkező esetben hozzáadjuk a terméket a kosárhoz, ha a mennyiség pozitív
        if ($quantity > 0) {
            $_SESSION['cart'][$productId] = $quantity;
        }
        else {
            echo json_encode(["status" => "failed", "message" => "Invalid quantity for new product - ".$quantity]);
            return;
        }
    }

    // Kosárban lévő termékek darabszámának összesítése
    $cartCount = getCartCount();
    $_SESSION['cartTotal'] = $cartCount;
    echo json_encode(['status' => 'success', 'message' => 'Cart updated. ID: '.$productId, 'cartCount' => $cartCount]);
}

function getCartCount() {
    if (!isset($_SESSION['cart'])) {
        return 0;
    }

    return array_sum($_SESSION['cart']);
}

