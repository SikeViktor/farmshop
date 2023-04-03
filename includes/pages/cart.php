<?php
$product = new Products();
$order = new Orders();

$success = null;
$total = 0;

if (isset($_POST["removed_product_id"])) {
    array_splice($_SESSION["product_in_cart"], $_POST["removed_product_id"], 1);
    header("Refresh:0");
}
if (isset($_POST["refresh"])) {
    $_SESSION["product_in_cart"][$_POST["refresh_product_id"]]["quantity"] = $_POST["quantity"];
    header("Refresh:0");
}

if (isset($_POST['buy'])) {
    $user_id = $_SESSION["userid"];
    $total2 = $_POST["total2"];
    $order_comment = $_POST["comment"];
    $order_items = $_SESSION["product_in_cart"];

    try {
        $result = $order->createOrder($user_id, $total2, $order_comment, $order_items);
        foreach ($_SESSION["product_in_cart"] as $cartProduct) {
            $product->updateProductQuantity($cartProduct["product_id"], $cartProduct["quantity"]);
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }

    if ($result) {
        $success = true;
        unset($_SESSION["product_in_cart"]);
        header("Refresh:3, url=/orders.php");
    } else {
        $success = false;
    }
}
if (isset($success)) {
    if ($success) echo '<div class="alert alert-success w-50 mx-auto mt-3" role="alert">
                        <div class="row text-center my-2"><i class="fa-solid fa-square-check text-success fa-5x"></i></div>
                        <div class="row justify-content-center">Sikeres Rendelés!</div>
                        </div>';
    else echo '<div class="alert alert-danger w-50 mx-auto mt-3" role="alert">
                <div class="row text-center my-2"><i class="fa-solid fa-circle-exclamation text-danger fa-5x"></i></div>
                <div class="row justify-content-center">Sikertelen Rendelés!</div>
                </div>';
}

?>

<div class="row"></div>


<div class="row py-5">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header">
                Kosár tartalma
            </div>
            <div class="card-body">

                <?php
                if (!isset($_SESSION["product_in_cart"]) || count($_SESSION["product_in_cart"]) == 0)
                    echo "<div class=\"mb-3 text-center\">Kosár tartalma üres!</div>";
                else {
                    for ($i = 0; $i < count($_SESSION["product_in_cart"]); $i++) {
                        $result = $product->getProductById($_SESSION["product_in_cart"][$i]["product_id"]);
                ?>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <img src="<?php echo $result["product_img_path"]; ?>" alt="product1" class="img-fluid">
                            </div>
                            <div class="col-md-9">
                                <h5 class="mb-2"><?php echo $result["product_name"]; ?></h5>
                                <p class="mb-2"><?php echo $result["category_name"]; ?></p>
                                <form action="<?php echo $GLOBALS["url"] ?>/cart.php" method="post">
                                    <div class="input-group mb-3">
                                        <button class="btn btn-outline-secondary minus-btn" type="button">-</button>
                                        <input name="quantity" type="number" class="form-control text-center quantity-input" value="<?php echo $_SESSION["product_in_cart"][$i]["quantity"]; ?>" min="1" max="<?php echo $result["product_quantity"]; ?>">
                                        <button class="btn btn-outline-secondary plus-btn" type="button">+</button>
                                    </div>
                                    <input type="hidden" name="refresh_product_id" value=<?php echo $i; ?>>
                                    <div class="row justify-content-center">
                                        <button class="btn btn-warning text-white col-2" name="refresh" type="submit"><i class="fa-solid fa-arrows-rotate"></i></button>
                                    </div>
                                </form>
                                <?php $subtotal = $_SESSION["product_in_cart"][$i]["quantity"] * $result["product_price"]; ?>
                                <p class="mb-2">Egységár: <?php echo $result["product_price"]; ?> Ft</p>
                                <p class="mb-2">Részösszeg: <?php echo $subtotal; ?> Ft</p>
                                <form action="<?php echo $GLOBALS["url"] ?>/cart.php" method="post">
                                    <input type="hidden" name="removed_product_id" value=<?php echo $i; ?>>
                                    <button class="btn btn-danger col" type="submit">Törlés a kosárból</button>
                                </form>

                            </div>
                        </div>
                        <hr>
                <?php $total += $subtotal;
                    }
                } ?>
            </div>
        </div>
        <form action="<?php echo $GLOBALS["url"] ?>/cart.php" method="post" id="buyForm">
            <div class="card mb-4">
                <div class="card-header">
                    Megjegyzés
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <textarea class="form-control" id="note" rows="3" name="comment"></textarea>
                    </div>
                </div>
            </div>
    </div>
    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header">
                Összegzés
            </div>
            <div class="card-body">
                <p class="mb-2">Összesen: <?php echo $total; ?> Ft</p>
                <p class="mb-2">Szállítás: ? Ft</p>
                <hr>
                <div class="row">
                    <div class="col-sm-8">
                        <p class="mb-0">Végösszeg: <input class="col-3 text-end" type="number" name="total2" value=<?php echo $total; ?> readonly> Ft</p>
                    </div>
                </div>
                <input type="hidden" name="buy">
                <button type="submit" class="btn btn-primary mt-3 btn-block" <?php if (isset($_SESSION["product_in_cart"]) && count($_SESSION["product_in_cart"]) > 0) echo "";
                                                                                else echo "disabled"; ?>>Fizetés</button>


            </div>
        </div>
    </div>
    </form>

</div>


<script>
    // Add event listener to the quantity input field
    var quantityInputs = document.querySelectorAll(".quantity-input");

    quantityInputs.forEach(function(input) {
        input.addEventListener("change", function() {
            var value = parseInt(input.value);
            var min = parseInt(input.min);
            var max = parseInt(input.max);

            if (value < min) {
                input.value = min;
            } else if (value > max) {
                input.value = max;
            }
        });
    });

    // Add event listeners to the plus and minus buttons
    var minusButtons = document.querySelectorAll(".minus-btn");
    var plusButtons = document.querySelectorAll(".plus-btn");

    minusButtons.forEach(function(button) {
        button.addEventListener("click", function() {
            var input = button.parentElement.querySelector(".quantity-input");
            var value = parseInt(input.value);
            var min = parseInt(input.min);

            if (value > min) {
                value--;
                input.value = value;
            }
        });
    });

    plusButtons.forEach(function(button) {
        button.addEventListener("click", function() {
            var input = button.parentElement.querySelector(".quantity-input");
            var value = parseInt(input.value);
            var max = parseInt(input.max);

            if (value < max) {
                value++;
                input.value = value;
            }
        });
    });
</script>