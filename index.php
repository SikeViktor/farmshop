<?php
session_start();
define('REQUIRED_FIELD_ERROR', 'Mező kitöltése kötelező!');
$hidden = "";

$url = "/farmshop";

if (!isset($_SESSION["product_in_cart"]))
    $_SESSION["product_in_cart"] = [];

require "classes/database/db.php";
require_once "classes/auth/login.php";
require "classes/auth/signup.php";
require "classes/modals.php";
require "classes/imageupload.php";

require "classes/users.php";
require "classes/products.php";
require "classes/orders.php";

//header
require "includes/header.php";

switch ($_SERVER["REQUEST_URI"]) {
    case $url . '/':
    case $url . '/index.php':
        require "includes/pages/main.php";
        break;
    case $url . '/login.php':
        require "includes/pages/login.php";
        break;
    case $url . '/register.php':
        require "includes/pages/registration.php";
        break;
    case $url . '/userdata.php':
        require "includes/pages/userdata.php";
        break;
    case preg_match('/' . preg_quote($url, '/') . '\/products\.php(\?\w\W)*/', $_SERVER["REQUEST_URI"]) ? true : false:
        require "includes/pages/products.php";
        break;
    case $url . '/cart.php':
        require "includes/pages/cart.php";
        break;
    case preg_match('/' . preg_quote($url, '/') . '\/product\.php(\?\w\W)*/', $_SERVER["REQUEST_URI"]) ? true : false:
        require "includes/pages/product.php";
        break;
    case $url . '/orders.php':
        require "includes/pages/myorders.php";
        break;
    case preg_match('/' . preg_quote($url, '/') . '\/admin\.php(\?\w\W)*/', $_SERVER["REQUEST_URI"]) ? true : false:
        require "includes/pages/admin/admin.php";
        break;
    default:
        http_response_code(404);
        break;
}

//footer
require "includes/footer.php";

?>