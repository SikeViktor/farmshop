<?php
$products = new Products();

$elements = 12;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$searchName = isset($_GET["searchname"]) ? $_GET["searchname"] : "";
$searchCategory = isset($_GET["searchcategory"]) ? $_GET["searchcategory"] : "";
$sortBy = isset($_GET["sortby"]) ? $_GET["sortby"] : "";

//var_dump($products->getProducts("", $page, $elements, "product_id", "DESC"));
//var_dump($products->getProductsByCategory($searchCategory,"", $page, $elements, "product_id", "DESC"));

/*$countProducts = count($products->getProducts($searchName, $page, $elements));
$total_pages = ceil($countProducts / $elements);*/
//$result = $products->getProducts($searchName, $page, $elements);

$categories = $products->getCategories();

switch ($sortBy) {
    case 'name':
        $result = $products->getProducts($searchName, $searchCategory, "product_name", "ASC", null, null);
        break;
    case 'price_asc':
        echo "ok";
        $result = $products->getProducts($searchName, $searchCategory, "product_price", "ASC", null, null);
        break;
    case 'price_desc':
        $result = $products->getProducts($searchName, $searchCategory, "product_price", "DESC", null, null);
        break;
    case 'newest':
        $result = $products->getProducts($searchName, $searchCategory, "product_created_at", "DESC", null, null);
        break;
    case 'oldest':
        $result = $products->getProducts($searchName, $searchCategory, "product_created_at", "ASC", null, null);
        break;

    default:
        $result = $products->getProducts($searchName, $searchCategory, null, null, null, null);
        break;
}
$countProducts = count($result);
$total_pages = ceil($countProducts / $elements);


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
        echo "<script>        
                if(confirm(\"Kosárba helyezéshez be kell jelentkezni!\"))
                    window.location.href = \"/farmshop/login.php\"        
            </script>";
    }
}
?>

<div class="col-12">
    <h2>Termékek</h2>
    <div class="col-md-6 offset-md-3">
        <form id="searchForm" method="get" action="/farmshop/products.php">
            <div class="input-group">
                <input type="text" name="searchname" value="<?php if (isset($_GET["searchname"])) echo $_GET["searchname"]; ?>" class="form-control" placeholder="Keresés...">

                <select class="form-select" name="searchcategory" aria-label="Default select example">
                    <option value="">Összes termék</option>
                    <?php
                    foreach ($categories as $cat) { ?>
                        <option value="<?php echo $cat['category_id']; ?>" <?php echo (isset($_GET["searchcategory"]) && $_GET["searchcategory"] == $cat['category_id']) ? "selected" : ""; ?>> <?php echo ucfirst($cat['category_name']); ?></option>;
                    <?php } ?>
                </select>

                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-search"></i></button>
            </div>
            <div class="input-group w-50 mt-4">
                <select class="form-select" name="sortby" aria-label="Default select example" id="sortingSelect">
                    <option <?php echo (!isset($_GET["sortby"]) || $_GET["sortby"] == "") ? "selected" : ""; ?> disabled>Rendezés</option>
                    <option value="name" <?php echo (isset($_GET["sortby"]) && $_GET["sortby"] == "name") ? "selected" : ""; ?>>Név szerinti</option>
                    <option value="price_asc" <?php echo (isset($_GET["sortby"]) && $_GET["sortby"] == "price_asc") ? "selected" : ""; ?>>Legolcsóbb elől</option>
                    <option value="price_desc" <?php echo (isset($_GET["sortby"]) && $_GET["sortby"] == "price_desc") ? "selected" : ""; ?>>Legdrágább elől</option>
                    <option value="newest" <?php echo (isset($_GET["sortby"]) && $_GET["sortby"] == "newest") ? "selected" : ""; ?>>Legújabb elől</option>
                    <option value="oldest" <?php echo (isset($_GET["sortby"]) && $_GET["sortby"] == "oldest") ? "selected" : ""; ?>>Legrégebbi elől</option>
                </select>
            </div>
        </form>
    </div>

    <div class="row p-3 mx-auto">

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
                            <h5 class="text-center">
                                <?php
                                $int = $products->getProductRating($product_id)["int"];
                                $float = floatval($products->getProductRating($product_id)["float"]);
                                for ($i = 0; $i < $int; $i++) {
                                    echo "<i class=\"fa-solid fa-star\"></i>";
                                }

                                if ($float < 0.25)
                                    echo "<i class=\"fa-regular fa-star\"></i>";
                                if ($float >= 0.25 && $float < 0.75)
                                    echo "<i class=\"fa-solid fa-star-half-stroke\"></i>";
                                if ($float >= 0.75)
                                    echo "<i class=\"fa-solid fa-star\"></i>";

                                for ($i = 1; $i < 5 - $int; $i++) {
                                    echo "<i class=\"fa-regular fa-star\"></i>";
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

        <?php }
        /*echo "<ul class=\"pagination\">";
        for ($i = 1; $i <= $total_pages; $i++) {
            $active = ($i == $page) ? "active" : "";
            echo "<li class=\"page-item $active\"><a class=\"page-link\" href=\"?page=$i\">$i</a></li>";
        }
        echo "</ul>";*/
        ?>

    </div>

</div>


<script>
    const mySelect = document.querySelector('#sortingSelect');
    const myForm = document.querySelector('#searchForm');
    sortingSelect.addEventListener('change', function() {
        searchForm.submit();
    });
</script>