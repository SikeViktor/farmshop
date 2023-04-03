<?php
require "validation/loginValidation.php";


?>

<div class="row justify-content-center my-5">
    <div class="col-md-8 col-lg-6">
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white text-center">
                FarmShop Bejelentkezés
            </div>
            <div class="card-body text-center">
                <form action="<?php echo $GLOBALS["url"] ?>/login.php" method="post">
                    <div class="mb-3">
                        <label for="username" class="form-label">Felhasználónév</label>
                        <input class="form-control <?php echo isset($errors['username']) ? 'is-invalid' : '' ?>" name="username" value="<?php echo $username ?>">
                        <div class="invalid-feedback">
                            <?php echo $errors['username'] ?? '' ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Jelszó</label>
                        <input type="password" class="form-control <?php echo isset($errors['password']) ? 'is-invalid' : '' ?>" name="password" value="<?php echo $password ?>">
                        <div class="invalid-feedback">
                            <?php echo $errors['password'] ?? '' ?>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                </form>
                <div class="my-3">
                    <p>Ha nincs még fiókod, <a href="<?php echo $GLOBALS["url"] ?>/register.php">itt</a> regisztrálhatsz.</p>
                    <form action="<?php echo $GLOBALS["url"] ?>/login.php" method="post" class="text-end">
                        <input type="hidden" name="username" value="demo">
                        <input type="hidden" name="password" value="demo">
                        <button type="submit" class="btn btn-warning btn-block">Demo</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>