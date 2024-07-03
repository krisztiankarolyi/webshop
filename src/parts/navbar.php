<nav class="navbar has-background-black  is-fixed-top" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <a class="navbar-item" href="#">
            <img src="../src/img/logo.png" width="100px" ">
        </a>

        <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
        </a>
    </div>

    <div id="navbarBasicExample" class="navbar-menu">
        <div class="navbar-start">
            <a class="navbar-item" href="#home" onclick="loadPage('home')">
                Home
            </a>

            <a class="navbar-item" href="#products" onclick="loadPage('products')">
                Products
            </a>

            <a class="navbar-item" href="#cart" onclick="loadPage('cart')">
                Cart (<?php
                session_start();
                if(!isset($_SESSION['cartTotal'])) $_SESSION['cartTotal'] = 0;
                echo "<span id='cartTotal'> " . $_SESSION['cartTotal'] . "</span>";
                ?>)
            </a>

        </div>

        <div class="navbar-end">
            <div class="navbar-item">
                <div class="buttons">
                    <?php

                    if (!isset($_SESSION['user_id'])) { ?>
                        <a class="button is-light" href="#login" onclick="loadPage('login')">
                            Log in
                        </a>
                    <?php }
                    else{
                        echo"<span>Logged in as </span>".$_SESSION['user_name'];
                        echo " <a class='button is-primary' href='logout'> <strong>Log out</strong> </a>";
                    } ?>
                </div>
            </div>
        </div>
    </div>
</nav>