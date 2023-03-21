<table class="table">
    <thead>
        <tr>
            <th>Rendelés azonosító</th>
            <th>Végösszeg</th>
            <th>Rendelés megjegyzés</th>
            <th>Rendelés leadva</th>
        </tr>
    </thead>
    <?php
    $orders = new Orders();

    $myOrders = $orders->getOrders($_SESSION["userid"]);

    foreach ($myOrders as $order) {
        $orderItems = $orders->getOrderItems($order["order_id"]);
    ?>
        <tbody>
            <tr data-bs-toggle="collapse" data-bs-target="#order-items-<?php echo $order["order_id"] ?>">
                <td><?php echo $order["order_id"] ?></td>
                <td><?php echo $order["total"] ?> Ft</td>
                <td><?php echo $order["order_comment"] ?></td>
                <td><?php echo $order["created_at"] ?></td>
            </tr>

            <tr class="collapse" id="order-items-<?php echo $order["order_id"] ?>">
                <td colspan="4">                    
                            <?php foreach ($orderItems as $orderItem) { ?>
                                <div class="row mb-3 border w-75 mx-auto">
                                    <div class="col-md-3">
                                        <img src="<?php echo $orderItem["product_img_path"]; ?>" alt="product1" class="img-fluid">
                                    </div>
                                    <div class="col-md-9">
                                        <h5 class="mb-2"><?php echo $orderItem["product_name"]; ?></h5>
                                        <p class="mb-2">Darabszám: <?php echo $orderItem["quantity"]; ?></p>                                        
                                        <p class="mb-2">Egységár: <?php echo $orderItem["product_price"]; ?> Ft</p>                                        
                                    </div>
                                </div>
                                <hr>                                
                            <?php } ?>                        
                </td>
            </tr>
        <?php } ?>
        </tbody>
</table>