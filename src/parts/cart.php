<?php
require_once ('../models/cart.php');


$cartContents = getCart();
var_dump($cartContents); // Check if this shows the correct cart items