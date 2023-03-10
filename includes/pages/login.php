<?php
require "validation/loginValidation.php";

?>

<!-- <form action="" method="post" novalidate>
    <div class="row">
        <div class="col">
            <div class="form-group">
                <label>Felhasználónév</label>
                <input class="form-control <?php echo isset($errors['username']) ? 'is-invalid' : '' ?>"
                       name="username" value="<?php echo $username ?>">                
                <div class="invalid-feedback">
                    <?php echo $errors['username'] ?? '' ?>
                </div>
            </div>
        </div>        
    </div>
    <div class="row">
        <div class="col">
            <div class="form-group">
                <label>Jelszó</label>
                <input type="password" class="form-control <?php echo isset($errors['password']) ? 'is-invalid' : '' ?>"
                       name="password" value="<?php echo $password ?>">
                <div class="invalid-feedback">
                    <?php echo $errors['password'] ?? '' ?>
                </div>
            </div>
        </div>        
    </div>    

    <div class="form-group">
        <button type="submit" class="btn btn-primary">Belépés</button>
    </div>
</form> -->


<div class="row justify-content-center my-5">
    <div class="col-md-8 col-lg-6">
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white text-center">
                FarmShop Bejelentkezés
            </div>
            <div class="card-body">
                <form action="" method="post">
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
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="rememberMe">
                            <label class="form-check-label" for="rememberMe">
                                Remember me
                            </label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                </form>
            </div>
        </div>
    </div>
</div>