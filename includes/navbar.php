<nav class="navbar navbar-expand-lg bg-success">
    <div class="container-fluid">
        <a class="col-lg-1 navbar-brand text-white" href="<?php echo $GLOBALS["url"] ?>/">FarmShop</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="col offset-lg-1 navbar-nav mb-2 mb-lg-0 justify-content-center">
                <li class="nav-item px-lg-4">
                    <a class="nav-link text-white" href="<?php echo $GLOBALS["url"] ?>/"><i class="fa-solid fa-house"></i> Főoldal</a>
                </li>
                <li class="nav-item dropdown px-lg-4">
                    <a class="nav-link dropdown-toggle text-white" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-box"></i> Termékek
                    </a>
                    <ul class="dropdown-menu dropdown-menu">
                        <li><a class="dropdown-item " href="<?php echo $GLOBALS["url"] ?>/products.php">Összes termék</a></li>
                        <!-- <li>
                        <hr class="dropdown-divider">
                        </li>-->
                    </ul>
                </li>
            </ul>
            <ul class="navbar-nav mb-lg-2 col-lg-2 justify-content-center">
                <?php
                $user=new Users();
                $navbar="";
                if (!isset($_SESSION["userid"]) && !isset($_SESSION["username"])) {
                    $navbar = '<li class="ml-5"><a href="' . $GLOBALS["url"] . '/login.php" class="btn btn-dark" role="button"><i class="fa-solid fa-right-to-bracket"></i> Bejelentkezés</a></li>';
                } else {
                    $navbar = '<li class="nav-item mx-lg-2 me-lg-4 position-relative">
                    <a class="nav-link text-white" href="' . $GLOBALS["url"] . '/cart.php">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span class="position-absolute top-n1 start-100 translate-middle badge bg-danger rounded-circle p-2"';
                    if (count($_SESSION["product_in_cart"]) == 0) {
                        $navbar .= ' hidden';
                    }
                    $navbar .= '>' . count($_SESSION["product_in_cart"]) . '<span class="visually-hidden">cart items</span></span>
                    </a>
                    </li>          
                    <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white me-lg-3" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    ' . $_SESSION["username"] . '
                    </a>
                    <ul class="dropdown-menu dropdown-menu-lg-end">';
                    if ($user->getUserById($_SESSION["userid"])["user_category"]==1)
                        $navbar .= '<li><a href="' . $GLOBALS["url"] . '/admin.php" class="dropdown-item" role="button"><i class="fa-solid fa-user"></i> Admin felület</a></li>';
                    $navbar .= '<li><a href="' . $GLOBALS["url"] . '/userdata.php" class="dropdown-item" role="button"><i class="fa-solid fa-user"></i> Adataim</a></li>
                    <li><a href="' . $GLOBALS["url"] . '/orders.php" class="dropdown-item" role="button"><i class="fa-solid fa-bag-shopping"></i> Rendeléseim</a></li>
                    <li><form method="post"><button type="submit" class="dropdown-item" name="logoutbtn"><i class="fa-solid fa-arrow-right-from-bracket"></i> Kijelentkezés</button></form></li>              
                    </ul>
                    </li>
                    ';

                    if (array_key_exists('logoutbtn', $_POST)) {
                        session_destroy();
                        header("Location: ". $GLOBALS["url"] ."");
                    }
                };
                echo $navbar;
                ?>

            </ul>
        </div>
    </div>

</nav>