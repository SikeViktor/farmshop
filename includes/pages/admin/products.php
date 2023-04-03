<?php

$uploader = new ImageUploader('images/products');
$categories = $products->getCategories();

function imagePath($iPath)
{
    if (isset($_FILES["product_img_path"]) && $_FILES["product_img_path"]["error"] == 0) {
        echo "images/products/" . $_FILES["product_img_path"]["name"];
        return "images/products/" . $_FILES["product_img_path"]["name"];
    } else {
        echo $iPath;
    }
}

if (isset($_FILES["product_img_path"])) {
    try {
        $newFileName = $uploader->uploadImage($_FILES['product_img_path'], $_FILES["product_img_path"]['name']);
        echo 'File uploaded successfully with name: ' . $newFileName;
    } catch (Exception $e) {
        echo 'Error uploading file: ' . $e->getMessage();
    }
    //var_dump($_FILES);
}

if (isset($_POST["updateProduct"])) {
    try {
        $products->updateProduct($_POST["product_id"], $_POST["product_name"], $_POST["product_description"], $_POST["category"], $_POST["product_quantity"], $_POST["product_price"], $_POST["product_discount_percent"], $_POST["product_img_path"]);
    } catch (Exception $e) {
        echo 'Error updating: ' . $e->getMessage();
    }
    var_dump($_POST);
}

if (isset($_POST["newProduct"])) {
    try {
        $products->newProduct($_POST["product_name"], $_POST["product_description"], $_POST["category"], $_POST["product_quantity"], $_POST["product_price"], $_POST["product_discount_percent"], $_POST["product_img_path"]);
        var_dump($_POST);
    } catch (Exception $e) {
        echo 'Error updating: ' . $e->getMessage();
    }
    
}

?>

<div class="d-flex justify-content-end">
    <a href="<?php echo $_SERVER['REQUEST_URI'] . '&product=new' ?>" class="btn btn-success"><i class="fas fa-plus-circle"></i> Új termék</a>
</div>

<?php if (isset($_GET["product"]) && $_GET["product"] == "new") { ?>

    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white text-center">Új termék felvétele</div>
                <div class="card-body text-center">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <img src="<?php imagePath(null); ?>" class="w-50" alt="">
                            <input class="form-control" type="file" accept="image/png, image/jpeg" name="product_img_path">
                            <button type="submit" name="uploadImage" class="btn btn-primary btn-block mt-2">Feltöltés</button>
                        </div>
                    </form>
                    <form action="" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="product_img_path" value="<?php imagePath(null); ?>">                        
                        <div class="mb-3 w-50 mx-auto">
                            <label for="product_name" class="form-label">Termék neve</label>
                            <input class="form-control" type="text" name="product_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="product_description" class="form-label">Termék leírása</label>
                            <textarea class="form-control" name="product_description" rows="5" required></textarea>
                        </div>
                        <div class="mb-3 w-50 mx-auto">
                            <label for="category_name" class="form-label">Kategória</label>
                            <select class="form-select" name="category">
                                <?php
                                foreach ($categories as $cat) { ?>
                                    <option value="<?php echo $cat['category_id']; ?>"> <?php echo $cat['category_name']; ?></option>;
                                <?php } ?>
                            </select>
                        </div>
                        <div class="mb-3 w-50 mx-auto">
                            <label for="product_quantity" class="form-label">Elérhető mennyiség</label>
                            <input class="form-control" type="number" name="product_quantity" min="0" required>
                        </div>
                        <div class="mb-3 w-50 mx-auto">
                            <label for="product_price" class="form-label">Termék ára</label>
                            <div class="input-group">
                                <input class="form-control" type="number" name="product_price" min="0" required>
                                <span class="input-group-text">Ft</span>
                            </div>
                        </div>
                        <div class="mb-3 w-50 mx-auto">
                            <label for="product_discount_percent" class="form-label">Kedvezmény mértéke</label>
                            <div class="input-group">
                                <input class="form-control" type="number" name="product_discount_percent" min="0" required>
                                <span class="input-group-text">%</span>
                            </div>
                        </div>                        

                        <button type="submit" name="newProduct" class="btn btn-primary btn-block">Hozzáad</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


<?php } else { ?>

    <table class="table my-5">
        <thead>
            <tr>
                <th scope="col">Azonosító</th>
                <th scope="col">Termék neve</th>
                <th scope="col">Egységár</th>
                <th scope="col">Műveletek</th>
            </tr>
        </thead>
        <tbody>
            <?php $result = $products->getProducts();            

            foreach ($result as $row) {
            ?>
                <tr>
                    <th scope="row" class="col-2"><?php echo $row["product_id"]; ?></th>
                    <td><?php echo $row["product_name"]; ?></td>
                    <td><?php echo $row["product_price"]; ?> Ft</td>
                    <td class="col-2"><a href="<?php echo $GLOBALS["url"] ?>/product.php?id=<?php echo $row["product_id"]; ?>" role="button" class="btn btn-primary"><i class="fa-solid fa-eye"></i></a>
                        <button type="button" class="btn btn-secondary" data-bs-toggle="collapse" data-bs-target="#product-<?php echo $row["product_id"] ?>"><i class="fa-solid fa-pencil"></i></button>
                        <button type="button" class="btn btn-danger"><i class="fa-solid fa-trash"></i></button>
                    </td>
                </tr>
                <tr class="collapse" id="product-<?php echo $row["product_id"] ?>">
                    <td colspan="4">
                        <div class="row justify-content-center">
                            <div class="col-md-10 col-lg-8">
                                <div class="card shadow-sm">
                                    <div class="card-header bg-success text-white text-center">
                                        "<?php echo $row["product_id"]; ?>" azonosítójú termék
                                    </div>
                                    <div class="card-body text-center">
                                        <form action="" method="post" enctype="multipart/form-data">
                                            <div class="mb-3">
                                                <img src="<?php imagePath($row["product_img_path"]); ?>" class="w-50" alt="">
                                                <input class="form-control" type="file" accept="image/png, image/jpeg" name="product_img_path">
                                                <button type="submit" name="uploadImage" class="btn btn-primary btn-block mt-2">Feltöltés</button>
                                            </div>
                                        </form>
                                        <form action="" method="post" enctype="multipart/form-data">
                                            <input type="hidden" name="product_img_path" value="<?php imagePath($row["product_img_path"]); ?>">
                                            <input type="hidden" name="product_id" value="<?php echo $row["product_id"]; ?>">
                                            <div class="mb-3 w-50 mx-auto">
                                                <label for="product_name" class="form-label">Termék neve</label>
                                                <input class="form-control" type="text" name="product_name" value="<?php echo $row["product_name"]; ?>">
                                            </div>
                                            <div class="mb-3">
                                                <label for="product_description" class="form-label">Termék leírása</label>
                                                <textarea class="form-control" name="product_description" rows="5"><?php echo $row["product_description"]; ?></textarea>
                                            </div>
                                            <div class="mb-3 w-50 mx-auto">
                                                <label for="category_name" class="form-label">Kategória</label>
                                                <select class="form-select" name="category">
                                                    <?php
                                                    foreach ($categories as $cat) { ?>
                                                        <option value="<?php echo $cat['category_id']; ?>" <?php echo ($cat['category_id'] == $row["category_id"]) ? "selected" : ""; ?>> <?php echo $cat['category_name']; ?></option>;
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="mb-3 w-50 mx-auto">
                                                <label for="product_quantity" class="form-label">Elérhető mennyiség</label>
                                                <input class="form-control" type="number" name="product_quantity" min="0" value="<?php echo $row["product_quantity"]; ?>">
                                            </div>
                                            <div class="mb-3 w-50 mx-auto">
                                                <label for="product_price" class="form-label">Termék ára</label>
                                                <div class="input-group">
                                                    <input class="form-control" type="number" name="product_price" min="0" value="<?php echo $row["product_price"]; ?>">
                                                    <span class="input-group-text">Ft</span>
                                                </div>
                                            </div>
                                            <div class="mb-3 w-50 mx-auto">
                                                <label for="product_discount_percent" class="form-label">Kedvezmény mértéke</label>
                                                <div class="input-group">
                                                    <input class="form-control" type="number" name="product_discount_percent" min="0" value="<?php echo $row["product_discount_percent"]; ?>">
                                                    <span class="input-group-text">%</span>
                                                </div>
                                            </div>
                                            <div class="mb-3 w-50 mx-auto">
                                                <label for="product_created_at" class="form-label">Termék létrehozva</label>
                                                <input class="form-control" type="date" name="product_created_at" value="<?php echo $row["product_created_at"]; ?>" disabled>
                                            </div>
                                            <div class="mb-3 w-50 mx-auto">
                                                <label for="product_modified_at" class="form-label">Termék módosítva</label>
                                                <input class="form-control" type="date" name="product_modified_at" value="<?php echo $row["product_modified_at"]; ?> " disabled>
                                            </div>

                                            <button type="submit" name="updateProduct" class="btn btn-primary btn-block">Mentés</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>

            <?php } ?>

        </tbody>
    </table>

<?php } ?>