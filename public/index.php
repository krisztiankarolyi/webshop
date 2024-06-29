
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="../src/style/bulma/bulma.css"></link>
        <link rel="stylesheet" type="text/css" href="../src/style/bulma/index.css"></link>
    </head>
    <body>
    <?php include 'navbar.php'; ?>

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
        include $page . '.php';
        ?>
    </div>

    <script src="../src/js/navbar.js"></script>
    <script src="../src/js/app.js"></script>
    </body>
</html>

