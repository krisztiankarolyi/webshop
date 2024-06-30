<?php
session_start(); // Munkamenet (session) kezdése vagy folytatása

// Funkció a kosárba helyezéshez
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
}

// Funkció a kosárból való eltávolításhoz
function removeFromCart($productId)
{
    // Ha van ilyen termék a kosárban, töröljük
    if (isset($_SESSION['cart'][$productId])) {
        unset($_SESSION['cart'][$productId]);
    }

    // Kosárban lévő termékek darabszámának frissítése
    $_SESSION['cartTotal'] = array_sum($_SESSION['cart']);
}

// Funkció a kosár tartalmának lekérdezéséhez
function getCart()
{
    // Ha van kosár tömb a munkamenetben, visszaadjuk
    if (isset($_SESSION['cart'])) {
        return $_SESSION['cart'];
    } else {
        return array(); // Ha nincs kosár, üres tömböt adunk vissza
    }
}


// Példa: Termék hozzáadása a kosárhoz
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['action'] === 'add') {
        $productId = $_POST['product_id'];
        $quantity = $_POST['quantity'];
        addToCart($productId, $quantity);
        echo json_encode(['status' => 'success', 'message' => 'Product added to cart', 'id' => $productId, 'quantity' => $quantity]);
        exit;
    }
    elseif ($_POST['action'] === 'remove') {
        $productId = $_POST['product_id'];
        removeFromCart($productId);
        echo json_encode(['status' => 'success', 'message' => 'Product removed from cart']);
        exit;
    }
}


?>
