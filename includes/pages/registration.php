<?php
require "validation/signupValidation.php";
?>

<div class="row justify-content-center my-5">
    <div class="col-md-8 col-lg-6">
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white text-center">
                FarmShop Regisztráció
            </div>
            <div class="card-body">
                <form action="<?php echo $GLOBALS["url"] ?>/registration.php" method="post" novalidate>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label>Felhasználónév</label>
                                <input class="form-control <?php echo isset($errors['username']) ? 'is-invalid' : '' ?>" name="username" value="<?php echo $username ?>">
                                <div class="invalid-feedback">
                                    <?php echo $errors['username'] ?? '' ?>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control <?php echo isset($errors['email']) ? 'is-invalid' : '' ?>" name="email" value="<?php echo $email ?>">
                                <div class="invalid-feedback">
                                    <?php echo $errors['email'] ?? '' ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label>Jelszó</label>
                                <input type="password" class="form-control <?php echo isset($errors['password']) ? 'is-invalid' : '' ?>" name="password" value="<?php echo $password ?>">
                                <div class="invalid-feedback">
                                    <?php echo $errors['password'] ?? '' ?>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>Jelszó újra</label>
                                <input type="password" class="form-control <?php echo isset($errors['password_confirm']) ? 'is-invalid' : '' ?>" name="password_confirm" value="<?php echo $password_confirm ?>">
                                <div class="invalid-feedback">
                                    <?php echo $errors['password_confirm'] ?? '' ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-3">
                        <button class="btn btn-primary">Regisztráció</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>