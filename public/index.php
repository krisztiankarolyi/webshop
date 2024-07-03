
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="../src/style/bulma/bulma.css"></link>
        <link rel="stylesheet" type="text/css" href="../src/style/index.css"></link>
    </head>
    <body>
    <?php include '../src/parts/navbar.php'; ?>
    <br> <br> <br>
    <div id="content">
        <?php

        $page = 'home'; // alapértelmezett oldal
        if (isset($_SERVER['REQUEST_URI'])) {
            $uri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
            $page = end($uri);
            if (!in_array($page, ['home', 'products', 'about'])) {
                $page = 'home'; // alapértelmezett, ha az oldal nem létezik
            }
        }
        include "../src/parts/". $page . '.php';
        ?>
    </div>
    <script src="../config.js" defer></script>
    <script src="../src/js/navbar.js"></script>
    <script src="../src/js/app.js"></script>
    <script src="../src/js/login.js"></script>
    <script src="../src/js/cart.js"></script>
    </body>
</html>



