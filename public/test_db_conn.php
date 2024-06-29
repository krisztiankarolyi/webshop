<?php
require_once '../config/database.php';

$database = new Database();
$db = $database->getConnection();

if ($db) {
    echo "Sikeres adatbázis kapcsolat!<br>";

    // Próbálj meg lekérdezni egy kollekciót, például a 'products' kollekciót
    $productsCollection = $db->products;
    $products = $productsCollection->find()->toArray();

    if (!empty($products)) {
        echo "Termékek a 'products' kollekcióban:<br>";
        foreach ($products as $product) {
            echo "ID: " . $product['_id'] . " - Név: " . $product['name'] . "<br>";
        }
    } else {
        echo "Nincsenek termékek a 'products' kollekcióban.";
    }
} else {
    echo "Nem sikerült csatlakozni az adatbázishoz.";
}
?>
