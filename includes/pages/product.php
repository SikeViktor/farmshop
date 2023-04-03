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
            $exist=false;            
            for($i=0; $i<count($_SESSION["product_in_cart"]); $i++) {                                   
                if($_SESSION["product_in_cart"][$i]["product_id"] == $_POST["product_id"]) {                    
                    $_SESSION["product_in_cart"][$i]["quantity"] = $_SESSION["product_in_cart"][$i]["quantity"] + $_POST["quantity_input"]; 
                    $exist=true;
                    break;                                      
                }                
            } 
            if(!$exist) array_push($_SESSION["product_in_cart"], array("product_id"=>$_POST["product_id"], "quantity"=>$_POST["quantity_input"]));           
            header("Location:cart.php");
        }
    } else {
      header("Location:login.php");
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