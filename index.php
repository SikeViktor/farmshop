<?php
session_start();
define('REQUIRED_FIELD_ERROR', 'Mező kitöltése kötelező!');
$hidden = "";

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
    case '/farmshop/':
    case '/farmshop/index.php':
        require "includes/pages/main.php";
        break;
    case '/farmshop/login.php':
        require "includes/pages/login.php";
        break;
    case '/farmshop/register.php':
        require "includes/pages/registration.php";
        break;
    case '/farmshop/userdata.php':
        require "includes/pages/userdata.php";
        break;
    case preg_match('/^\/farmshop\/products\.php(\?\w\W)*/', $_SERVER["REQUEST_URI"]) ? true : false:
        require "includes/pages/products.php";
        break;
    case '/farmshop/cart.php':
        require "includes/pages/cart.php";
        break;
    case preg_match('/^\/farmshop\/product\.php(\?\w\W)*/', $_SERVER["REQUEST_URI"]) ? true : false:
        require "includes/pages/product.php";
        break;
    case '/farmshop/orders.php':
        require "includes/pages/myorders.php";
        break;
    case preg_match('/^\/farmshop\/admin\.php(\?\w\W)*/', $_SERVER["REQUEST_URI"]) ? true : false:
        require "includes/pages/admin/admin.php";
        break;
    default:
        http_response_code(404);
        break;
}

//footer
require "includes/footer.php";
?>

<pre>
    <?php var_dump($_SESSION);
    //var_dump($_SERVER["REQUEST_URI"]);    
    //var_dump($_SERVER['HTTP_REFERER']);  
    //var_dump($_POST); 

    /*$(document).ready(function() {
        $(".quantity-input").on("change", function() {
            var productIndex = $(this).data("product-index");
            var newQuantity = $(this).val();
            var productInCart = <?php echo json_encode($_SESSION["product_in_cart"]); ?>;
            productInCart[productIndex].quantity = newQuantity;
            <?php $_SESSION["product_in_cart"] = $productInCart; ?>
        });
    });*/


    ?>
</pre>