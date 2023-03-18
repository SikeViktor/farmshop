 <?php
    $product = new Products();
    $order = new Orders();

    if (isset($_POST["removed_product_id"])) {
        array_splice($_SESSION["product_in_cart"], $_POST["removed_product_id"], 1);
        header("Refresh:0");
    }

    if (isset($_POST['buy'])) {
        $user_id = $_SESSION["userid"];
        $total2 = $_POST["total2"];
        $order_comment = $_POST["comment"];
        $order_items = $_SESSION["product_in_cart"];        

        $result = $order->createOrder($user_id, $total2, $order_comment, $order_items);

        if ($result) {
            echo "Sikeres rendelés!";
            unset($_SESSION["product_in_cart"]);            
        } else {
            echo "Rendelés sikertelen!";            
        }
    }
    ?>

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
                             <div class="input-group mb-3">
                                 <button class="btn btn-outline-secondary minus-btn" type="button">-</button>
                                 <input type="number" class="form-control text-center quantity-input" value="<?php echo $_SESSION["product_in_cart"][$i]["quantity"]; ?>" min="1" max="<?php echo $result["product_quantity"]; ?>">
                                 <button class="btn btn-outline-secondary plus-btn" type="button">+</button>
                             </div>
                             <p class="mb-2">Egységár: <?php echo $result["product_price"]; ?> Ft</p>
                             <p class="mb-2 subtotal">Részösszeg: <?php echo $result["product_price"]; ?> Ft</p>
                             <form action="" method="post">
                                 <input type="hidden" name="removed_product_id" value=<?php echo $i; ?>>
                                 <button class="btn btn-danger" type="submit">Törlés a kosárból</button>
                             </form>
                         </div>
                     </div>
                     <hr>
                 <?php } } ?>
             </div>
         </div>
         <div class="card mb-4">
             <div class="card-header">
                 Megjegyzés
             </div>
             <div class="card-body">
                 <div class="mb-3">
                     <form action="" method="post" id="buyForm">
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
                 <p class="mb-2 total"></p>
                 <p class="mb-2">Szállítás: ? Ft</p>
                 <hr>
                 <div class="row">
                     <div class="col-sm-8">
                         <p class="mb-0">Végösszeg: <input class="col-3 text-end" type="number" name="total2" id="total2" disabled> Ft</p>
                     </div>
                 </div>

                 <input type="hidden" name="buy">
                 <button type="submit" class="btn btn-primary mt-3 btn-block" 
                 <?php if (isset($_SESSION["product_in_cart"]) && count($_SESSION["product_in_cart"]) > 0) echo "";
                 else echo "disabled"; ?>>Fizetés</button>
                 </form>

             </div>
         </div>
     </div>
 </div>


 <script>
     calculateTotal();
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

             calculateSubtotal(input);
             calculateTotal();
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
                 calculateSubtotal(input);
                 calculateTotal();
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
                 calculateSubtotal(input);
                 calculateTotal();
             }
         });
     });

     // Calculate the initial subtotal for each product
     var subtotals = document.querySelectorAll(".subtotal");

     subtotals.forEach(function(subtotal) {
         var input = subtotal.parentElement.querySelector(".quantity-input");
         calculateSubtotal(input);
     });

     // Function to calculate subtotal
     function calculateSubtotal(input) {
         var price = input.parentElement.nextElementSibling.innerHTML.replace("Egységár: ", "").replace(" Ft", "");
         var subtotal = input.parentElement.nextElementSibling.nextElementSibling;
         subtotal.innerHTML = "Részösszeg: " + (price * input.value) + " Ft";
     }

     // Function to calculate total
     function calculateTotal() {
         var subtotals = document.querySelectorAll(".subtotal");
         var total = 0;

         subtotals.forEach(function(subtotal) {
             var value = subtotal.innerHTML.replace("Részösszeg: ", "").replace(" Ft", "");
             total += parseInt(value);
         });

         var totalElement = document.querySelector(".total");
         totalElement.innerHTML = "Összesen: " + total + " Ft";
         document.getElementById("total2").value = total;

         return total;
     }     
 </script>