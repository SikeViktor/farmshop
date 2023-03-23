<?php

$orders=new Orders();
$products=new Products();
$users=new Users();

?>

<div class="row my-3">
    <div class="col-md-3 border-start border-end">
        <h2 class="text-center my-4">Admin Panel</h2>
        <ul class="nav flex-column mb-3">
            <li class="nav-item">
                <a class="nav-link" href="/farmshop/admin.php">Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/farmshop/admin.php?page=products">Termékek</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/farmshop/admin.php?page=orders">Rendelések</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/farmshop/admin.php?page=users">Felhasználók</a>
            </li>
        </ul>
    </div>
    <div class="col-md-9">
        <?php
        if (!isset($_GET["page"])) {
            require_once "includes/pages/admin/dashboard.php";
        } else {
            switch ($_GET["page"]) {
                case 'users':
                    require_once "includes/pages/admin/users.php";
                    break;
                case 'orders':
                    require_once "includes/pages/admin/orders.php";
                    break;
                case 'products':
                    require_once "includes/pages/admin/products.php";
                    break;
                default:

                    break;
            }
        }

        ?>
    </div>
</div>