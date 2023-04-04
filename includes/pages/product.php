<?php
$product = new Products();

$result = $product->getProductById($_GET["id"]);

$product_id = $result["product_id"];
$product_name = $result["product_name"];
$product_description = $result["product_description"];
$category_name = $result["category_name"];
$product_quantity = $result["product_quantity"];
$product_price = $result["product_price"];
$product_discount_percent = $result["product_discount_percent"];
$product_img_path = $result["product_img_path"];
$product_created_at = $result["product_created_at"];

if (isset($_POST["cart"])) {
    if (isset($_SESSION["userid"]) && isset($_SESSION["username"])) {
        if (isset($_POST["product_id"])) {
            $exist = false;
            for ($i = 0; $i < count($_SESSION["product_in_cart"]); $i++) {
                if ($_SESSION["product_in_cart"][$i]["product_id"] == $_POST["product_id"]) {
                    $_SESSION["product_in_cart"][$i]["quantity"] = $_SESSION["product_in_cart"][$i]["quantity"] + $_POST["quantity_input"];
                    $exist = true;
                    break;
                }
            }
            if (!$exist) array_push($_SESSION["product_in_cart"], array("product_id" => $_POST["product_id"], "quantity" => $_POST["quantity_input"]));
            header("Location:cart.php");
        }
    } else {
        header("Location:login.php");
    }
}

$ratings = $product->getProductRatings($product_id);

if (isset($_POST["sendreview"])) {
    if ($_POST["ratingnumber"] > 0) {
        $product->createProductRating($product_id, $_SESSION["userid"], $_POST["ratingnumber"], $_POST["review"], date("Y-m-d"));
        header("Refresh: 0");
    } else {
        echo "Nem lehet 0";
    }
}

?>

<div class="row">
    <div class="col-md-6">
        <img class="img-fluid" src=<?php echo $product_img_path; ?> alt="Product Image">
    </div>
    <div class="col-md-6">
        <h1 class="mb-4"><?php echo $product_name; ?></h1>
        <p class="text-muted mb-4"><?php echo $product_description; ?></p>
        <h2 class="mb-3"><?php echo $product_price; ?> Ft</h2>
        <form method="post">
            <div class="input-group mb-3">
                <button class="btn btn-outline-secondary minus-btn" type="button">-</button>
                <input type="number" name="quantity_input" class="form-control text-center quantity-input" value="1" min="1" max="<?php echo $result["product_quantity"]; ?>">
                <button class="btn btn-outline-secondary plus-btn" type="button">+</button>
            </div>

            <input type="hidden" name="product_id" value=<?php echo $product_id; ?>>
            <button class="btn btn-success" name="cart">Kosárba <i class="fa-solid fa-cart-shopping"></i></button>

        </form>
        <h3 class="mb-3">Termék adatai:</h3>
        <ul class="list-unstyled">
            <li><strong>Kategória:</strong> <?php echo $category_name; ?></li>
            <li><strong>Kedvezmény:</strong> <?php echo $product_discount_percent; ?> %</li>
            <li><strong>Létrehozva:</strong> <?php echo $product_created_at; ?></li>
        </ul>
    </div>
</div>

<div class="product-reviews">
    <h3>Értékelések</h3>
    <?php
    $count = $product->checkOrderItemsForRating($product_id, $_SESSION["userid"]);
    if (!isset($count) || $count <= 0) {
        echo "<p>Nem értékelhetsz, mivel még nem vásároltál ebből a termékből.</p>";
    } else {
    ?>
        <form action="" method="post">
            <div class="accordion" id="ratingAccordion">
                <div class="accordion-item card mb-4 col-8 mx-auto">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            <div>Értékelhetsz, mivel már <?php echo $count; ?> alkalommal vásároltál ebből a termékből.</div>
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#ratingAccordion">
                        <div class="accordion-body">
                            <div class="mb-3 text-center">
                                <?php for ($i = 1; $i < 6; $i++) {
                                    echo "<i class=\"fa-regular fa-star fa-xl ratingstars\" data-value='$i'></i>";
                                } ?>
                                <input type="hidden" id="rating" name="ratingnumber" value="0">
                            </div>
                            <div class="mb-3">
                                <textarea class="form-control" id="note" rows="3" name="review" placeholder="Írd le a véleményed a termékről..."></textarea>
                            </div>
                            <div class="text-center">
                                <button class="btn btn-success col-2" type="submit" name="sendreview">Értékel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    <?php } ?>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Felhasználó</th>
                <th>Értékelés</th>
                <th>Vélemény</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (empty($ratings)) {
                echo "<tr><td colspan='3'>Még nem értékelte senki...</td></tr>";
            } else {
                foreach ($ratings as $rating) { ?>
                    <tr>
                        <td class="col-2"><?php echo $rating["username"]; ?></td>
                        <td class="col-2 border-end">
                            <div class="product-rating">
                                <?php
                                for ($i = 0; $i < $rating["rating"]; $i++) {
                                    echo "<i class=\"fa-solid fa-star\"></i>";
                                }
                                for ($i = 0; $i < 5 - $rating["rating"]; $i++) {
                                    echo "<i class=\"fa-regular fa-star\"></i>";
                                }
                                ?>
                            </div>
                        </td>
                        <td class="col-8"><?php echo $rating["review"]; ?></td>
                    </tr>
            <?php }
            } ?>
        </tbody>
    </table>
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


    const stars = document.querySelectorAll('.ratingstars');
    stars.forEach(star => star.addEventListener('click', handleClick));

    function handleClick(event) {

        const clickedStar = event.target;
        const clickedValue = clickedStar.getAttribute('data-value');

        stars.forEach(star => {
            const starValue = star.getAttribute('data-value');
            if (starValue <= clickedValue) {
                star.classList.add('fa-solid');
                star.classList.remove('fa-regular');
            } else {
                star.classList.add('fa-regular');
                star.classList.remove('fa-solid');
            }
        });

        const ratingInput = document.getElementById('rating');
        ratingInput.value = clickedValue;
        console.log(ratingInput);
    }
</script>