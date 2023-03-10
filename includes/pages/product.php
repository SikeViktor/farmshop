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
$product_modified_at = $result["product_modified_at"];
$product_deleted_at = $result["product_deleted_at"];

?>

<div class="row">
    <div class="col-md-6">
        <img class="img-fluid" src=<?php echo $product_img_path; ?> alt="Product Image">
    </div>
    <div class="col-md-6">
        <h1 class="mb-4"><?php echo $product_name; ?></h1>
        <p class="text-muted mb-4"><?php echo $product_description; ?></p>
        <h2 class="mb-3"><?php echo $product_price; ?> Ft</h2>
        <form>
            <div class="form-group">
                <button type="button" class="btn bg-light border rounded-circle"><i class="fas fa-minus"></i></button>
                <input type="text" value="1" class="form-control w-25 d-inline">
                <button type="button" class="btn bg-light border rounded-circle"><i class="fas fa-plus"></i></button>
            </div>
            <button type="submit" class="btn btn-primary mb-4">Kosárba</button>
        </form>
        <h3 class="mb-3">Termék adatai:</h3>
        <ul class="list-unstyled">
            <li><strong>Kategória:</strong> <?php echo $category_name; ?></li>
            <li><strong>Kedvezmény:</strong> <?php echo $product_discount_percent; ?> %</li>
            <li><strong>Létrehozva:</strong> <?php echo $product_created_at; ?></li>
        </ul>
    </div>
</div>