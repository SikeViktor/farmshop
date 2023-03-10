<nav class="navbar navbar-expand-lg bg-success">
  <div class="container-fluid">
    <a class="col-lg-1 navbar-brand text-white" href="<?php echo $_SERVER['PHP_SELF']; ?>">FarmShop</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="col offset-lg-1 navbar-nav mb-2 mb-lg-0 justify-content-center">
        <li class="nav-item px-lg-4">
          <a class="nav-link text-white" href="<?php echo $_SERVER['PHP_SELF']; ?>"><i class="fa-solid fa-house"></i> Főoldal</a>
        </li>
        <!-- <li class="nav-item dropdown px-4">
          <a class="nav-link dropdown-toggle  text-white" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Tyúkok
          </a>
          <ul class="dropdown-menu dropdown-menu-dark">
            <li><a class="dropdown-item " href="">Állomány</a></li>
            <li><a class="dropdown-item" href">Keltetés</a></li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item" href="">Tojás</a></li>
          </ul>
        </li> -->
        <li class="nav-item px-lg-4">
          <a class="nav-link  text-white" href="<?php echo $_SERVER['PHP_SELF']; ?>"><i class="fa-solid fa-box"></i> Termékek</a>
        </li>
      </ul>
      <ul class="navbar-nav mb-lg-2 col-lg-2 justify-content-center">
        <?php if (!isset($_SESSION["userid"]) && !isset($_SESSION["username"])) {                     
          echo '<li class="ml-5"><a href="/farmshop/login.php" class="btn btn-dark" role="button"><i class="fa-solid fa-right-to-bracket"></i> Bejelentkezés</a></li>';
        } else {
          echo '
            <li class="nav-item mx-lg-2">
              <a class="nav-link text-white" href="/farmshop/favourite.php">
                <i class="fa-solid fa-heart"></i>
              </a>
            </li>
            <li class="nav-item mx-lg-2 me-lg-4 position-relative">
              <a class="nav-link text-white" href="/farmshop/cart.php">
                <i class="fa-solid fa-cart-shopping"></i>
                <span class="position-absolute top-n1 start-100 translate-middle badge bg-danger rounded-circle p-2"';
                if(count($_SESSION["product_in_cart"]) == 0){
                  echo ' hidden';
                }
                echo '>'.count($_SESSION["product_in_cart"]).'<span class="visually-hidden">cart items</span></span>
              </a>
            </li>          
            <li class="nav-item dropdown">            
              <a class="nav-link dropdown-toggle text-white me-lg-3" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                ' . $_SESSION["username"] . '
              </a>
              <ul class="dropdown-menu dropdown-menu-lg-end">
                <li><form method="post"><button type="submit" class="dropdown-item" name="logoutbtn"><i class="fa-solid fa-arrow-right-from-bracket"></i> Kijelentkezés</button></form></li>              
              </ul>
            </li>
          ';
          if (array_key_exists('logoutbtn', $_POST)) {
            session_destroy();
            header("Refresh:0");
          }
        }; ?>

      </ul>
    </div>
  </div>
</nav>