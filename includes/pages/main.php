<?php
$products = new Products();

$result = $products->getProducts();
//$_SESSION["product_in_cart"]=[];

//$products->newProduct("Valami", "Valami leírás", "gyümölcs", 100, 10, 0, "images/valami.jpg");

if (isset($_POST["cart"])) {
    if (isset($_SESSION["userid"]) && isset($_SESSION["username"])) {
        if(isset($_POST["product_id"])) {
            array_push($_SESSION["product_in_cart"], $_POST["product_id"]);
            header("Refresh:0");            
        }
    } else {
        echo "<script>        
                if(confirm(\"Kosárba helyezéshez be kell jelentkezni!\"))
                    window.location.href = \"/farmshop/login.php\"        
            </script>";
    }
}
?>

<div class="container mt-3">
    <div class="row justify-content-center">
        <?php
        foreach ($result as $row) {
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
                <a href="/farmshop/product.php?id=<?php echo $product_id ?>" class="text-decoration-none text-dark ">
                    <div class="card product h-100">
                        <img src="<?php echo $product_img_path; ?>" class="card-img-top p-3">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $product_name; ?></h5>
                            <p class="card-text"><?php echo $product_description; ?></p>
                            <h5 class="text-center"><i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-regular fa-star"></i>
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
        <?php } ?>
    </div>
</div>