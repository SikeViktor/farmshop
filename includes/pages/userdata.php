<?php
$user=new Users();

$userData=$user->getUserById($_SESSION["userid"]);

$username = $userData["username"];
$email = $userData["email"];
$firstname = $userData["firstname"];
$lastname = $userData["lastname"];
$phone = $userData["phone"];
$img_path = $userData["img_path"];
$created_at = $userData["created_at"];
$user_category_name = $userData["user_category_name"];

$errors = [];

?>

<div class="row justify-content-center my-5">    
    <div class="col-md-8 col-lg-6">
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white text-center">
                <?php echo $username;?> adatai
            </div>
            <div class="card-body text-center">
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="username" class="form-label">Felhasználónév</label>
                        <input class="form-control <?php echo isset($errors['username']) ? 'is-invalid' : '' ?>" name="username" value="<?php echo $username ?>">
                        <div class="invalid-feedback">
                            <?php echo $errors['username'] ?? '' ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input class="form-control <?php echo isset($errors['email']) ? 'is-invalid' : '' ?>" name="email" value="<?php echo $email ?>">
                        <div class="invalid-feedback">
                            <?php echo $errors['email'] ?? '' ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="lastname" class="form-label">Vezetéknév</label>
                        <input class="form-control <?php echo isset($errors['lastname']) ? 'is-invalid' : '' ?>" name="lastname" value="<?php echo $lastname ?>">
                        <div class="invalid-feedback">
                            <?php echo $errors['lastname'] ?? '' ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="firstname" class="form-label">Keresztnév</label>
                        <input class="form-control <?php echo isset($errors['firstname']) ? 'is-invalid' : '' ?>" name="firstname" value="<?php echo $firstname ?>">
                        <div class="invalid-feedback">
                            <?php echo $errors['firstname'] ?? '' ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Telefonszám</label>
                        <input class="form-control <?php echo isset($errors['phone']) ? 'is-invalid' : '' ?>" name="username" value="<?php echo $phone ?>">
                        <div class="invalid-feedback">
                            <?php echo $errors['phone'] ?? '' ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="img_path" class="form-label">Avatar</label>
                        <input class="form-control <?php echo isset($errors['img_path']) ? 'is-invalid' : '' ?>" name="img_path" value="<?php echo $img_path ?>">
                        <div class="invalid-feedback">
                            <?php echo $errors['img_path'] ?? '' ?>
                        </div>
                    </div>                    
                    <div class="mb-3">
                        <label for="created_at" class="form-label">Regisztrálás dátuma</label>
                        <input class="form-control" name="created_at" value="<?php echo $created_at ?>" disabled>                        
                    </div>
                    <div class="mb-3">
                        <label for="user_category_name" class="form-label">Fiók típusa</label>
                        <input class="form-control" name="user_category_name" value="<?php echo $user_category_name ?>" disabled>                        
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Mentés</button>
                </form>                
            </div>
        </div>
    </div>
</div>