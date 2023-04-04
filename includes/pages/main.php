<?php
$products = new Products();

$result = $products->getProducts(null, null, "product_created_at", "DESC");

//$_SESSION["product_in_cart"]=[];

if (isset($_POST["cart"])) {
    if (isset($_SESSION["userid"]) && isset($_SESSION["username"])) {
        if (isset($_POST["product_id"])) {
            $exist = false;
            for ($i = 0; $i < count($_SESSION["product_in_cart"]); $i++) {
                if ($_SESSION["product_in_cart"][$i]["product_id"] == $_POST["product_id"]) {
                    $_SESSION["product_in_cart"][$i]["quantity"] = $_SESSION["product_in_cart"][$i]["quantity"] + 1;
                    $exist = true;
                    break;
                }
            }
            if (!$exist) array_push($_SESSION["product_in_cart"], array("product_id" => $_POST["product_id"], "quantity" => "1"));
            header("Refresh:0");
        }
    } else {
        //Vissza a login képernyőre
        header("Location:login.php");
    }
}
?>

<div id="carouselMain" class="carousel slide mb-5 mt-3" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselMain" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselMain" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselMain" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">

        <div class="carousel-item active">
            <img src="./images/vegetables.png" class="d-block w-50 mx-auto" alt="...">
            <div class="carousel-caption d-none d-md-block">
                <h5>Zöldségek</h5>
            </div>
        </div>
        <div class="carousel-item">
            <img src="./images/fruits.png" class="d-block w-50 mx-auto" alt="...">
            <div class="carousel-caption d-none d-md-block">
                <h5>Gyümölcsök</h5>
            </div>
        </div>
        <div class="carousel-item">
            <img src="./images/eggs.png" class="d-block w-50 mx-auto" alt="...">
            <div class="carousel-caption d-none d-md-block">
                <h5>Állati termékek</h5>
            </div>
        </div>
    </div>
</div>

<div class="col-12">
    <h2>Legújabb termékek</h2>
    <div id="carouselNew" class="carousel carousel-dark slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="row p-3 mx-auto">
                <?php
                $count = 0;
                foreach (array_slice($result, 0, 8) as $row) {
                    if ($count % 4 == 0) {
                        if ($count == 0) {
                            echo '<div class="carousel-item active"><div class="row">';
                        } else {
                            echo '</div></div><div class="carousel-item"><div class="row">';
                        }
                    }
                    $product_id = $row['product_id'];
                    $product_name = $row['product_name'];
                    $product_description = $row['product_description'];
                    $product_price = $row['product_price'];
                    $product_img_path = $row['product_img_path'];
                    $category_name = $row['category_name'];
                    $product_quantity = $row['product_quantity'];
                    $product_discount_percent = $row['product_discount_percent'];
                ?>

                    <div class="col-md-3 mb-3">
                        <a href="<?php echo $GLOBALS["url"] ?>/product.php?id=<?php echo $product_id ?>" class="text-decoration-none text-dark ">
                            <div class="card product h-100">
                                <img src="<?php echo $product_img_path; ?>" class="card-img-top p-3">
                                <div class="card-body">
                                    <h5 class="card-title text-center"><?php echo $product_name; ?></h5>
                                    <h5 class="text-center">
                                        <?php
                                        $int = $products->getProductRating($product_id)["int"];
                                        $float = floatval($products->getProductRating($product_id)["float"]);

                                        if ($int==0 && $float==0) {
                                            echo "<span class='text-secondary fs-6'>Még nem értékelték</span>";

                                        } else {
                                            for ($i = 0; $i < $int; $i++) {
                                                echo "<i class=\"fa-solid fa-star\"></i>";
                                            }

                                            if ($float < 0.25 && $float > 0)
                                                echo "<i class=\"fa-regular fa-star\"></i>";
                                            if ($float >= 0.25 && $float < 0.75)
                                                echo "<i class=\"fa-solid fa-star-half-stroke\"></i>";
                                            if ($float >= 0.75 && $float < 1)
                                                echo "<i class=\"fa-solid fa-star\"></i>";

                                            $start = ($float == 0) ? 0 : 1;
                                            for ($i = $start; $i < 5 - $int; $i++) {
                                                echo "<i class=\"fa-regular fa-star\"></i>";
                                            }
                                        }

                                        ?>
                                    </h5>
                                    <h4 class="card-text text-center py-3"><?php echo $product_price; ?> Ft</h4>
                                    <form method="post" class="text-end">
                                        <input type="hidden" name="product_id" value=<?php echo $product_id; ?>>
                                        <button class="btn btn-success" name="cart">Kosárba <i class="fa-solid fa-cart-shopping"></i></button>
                                    </form>
                                </div>
                            </div>
                        </a>
                    </div>

                <?php
                    $count++;
                } ?>
            </div>
        </div>
    </div>
</div>
<button class="carousel-control-prev btn-dark" type="button" data-bs-target="#carouselNew" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Előző</span>
</button>
<button class="carousel-control-next" type="button" data-bs-target="#carouselNew" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Következő</span>
</button>
</div>

</div>