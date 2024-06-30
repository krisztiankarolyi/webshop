<?php
session_start(); // Session kezdése vagy folytatása

// Ellenőrizze, hogy a felhasználó be van-e jelentkezve
if (isset($_SESSION['user_id'])) {
    // Ha be van jelentkezve, törölje a session változókat
    session_unset(); // Minden session változó törlése
    session_destroy(); // Session lezárása

    // Opcionális: További munkamenet beállítások visszaállítása
    $_SESSION = array(); // Üres tömb inicializálása

    // Opcionális: A cookie-k is törlése, ha szükséges
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    // Átirányítás a kijelentkezés utáni oldalra (opcionális)
    header("Location: index.php"); // Példa: Visszairányítás az index.php oldalra
    exit(); // Kilépés a scriptből
} else {
    // Ha nincs bejelentkezve, átirányítás a bejelentkezési oldalra vagy más kezelés
    header("Location: login"); // Példa: Visszairányítás a bejelentkezési oldalra
    exit(); // Kilépés a scriptből
}
?>
