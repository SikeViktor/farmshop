<div class="row mt-5">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-title">Termékek</h5>
                    <p class="card-text"><?php echo $products->countProducts();?> db</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-title">Rendelések</h5>
                    <p class="card-text"><?php echo $orders->countOrders();?> db</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-title">Felhasználók</h5>
                    <p class="card-text"><?php echo $users->countUsers();?> db</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-title">Bevétel</h5>
                    <p class="card-text"><?php echo $orders->countOrders();?> Ft</p>
                </div>
            </div>
        </div>
</div>