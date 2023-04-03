<?php
$users = new Users();
$userData = $users->getUserById($_SESSION["userid"]);

$username = $userData["username"];
$email = $userData["email"];
$firstname = $userData["firstname"];
$lastname = $userData["lastname"];
$phone = $userData["phone"];
$img_path = $userData["img_path"];
$created_at = $userData["created_at"];
$user_category_name = $userData["user_category_name"];

$errors = [];

if (empty($errors) && isset($_POST["updateDatas"])) {
    try {
        $users->updateUser($_SESSION["userid"], $_POST["username"], $_POST["email"], $_POST["firstname"], $_POST["lastname"], $_POST["phone"], $_POST["img_path"]);
        header("Refresh:0");
    } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    }
}

?>

<div class="row justify-content-center my-5">
    <div class="col-md-8 col-lg-6">
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white text-center">
                <?php echo $username; ?> adatai
            </div>
            <div class="card-body text-center">
                <form action="<?php echo $GLOBALS["url"] ?>/userdata.php" method="post">
                    <div class="mb-3">
                        <label for="username" class="form-label">Felhasználónév</label>
                        <input id="username" class="form-control <?php echo isset($errors['username']) ? 'is-invalid' : '' ?>" name="username" value="<?php echo $username ?>">
                        <div class="invalid-feedback">
                            <?php echo $errors['username'] ?? '' ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input id="email" class="form-control <?php echo isset($errors['email']) ? 'is-invalid' : '' ?>" name="email" value="<?php echo $email ?>">
                        <div class="invalid-feedback">
                            <?php echo $errors['email'] ?? '' ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="lastname" class="form-label">Vezetéknév</label>
                        <input id="lastname" class="form-control <?php echo isset($errors['lastname']) ? 'is-invalid' : '' ?>" name="lastname" value="<?php echo $lastname ?>">
                        <div class="invalid-feedback">
                            <?php echo $errors['lastname'] ?? '' ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="firstname" class="form-label">Keresztnév</label>
                        <input id="firstname" class="form-control <?php echo isset($errors['firstname']) ? 'is-invalid' : '' ?>" name="firstname" value="<?php echo $firstname ?>">
                        <div class="invalid-feedback">
                            <?php echo $errors['firstname'] ?? '' ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Telefonszám</label>
                        <input id="phone" class="form-control <?php echo isset($errors['phone']) ? 'is-invalid' : '' ?>" name="phone" value="<?php echo $phone ?>">
                        <div class="invalid-feedback">
                            <?php echo $errors['phone'] ?? '' ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="img_path" class="form-label">Avatar</label>
                        <input id="img_path" class="form-control <?php echo isset($errors['img_path']) ? 'is-invalid' : '' ?>" name="img_path" value="<?php echo $img_path ?>">
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
                    <input type="hidden" name="updateDatas">
                    <button type="submit" class="btn btn-primary btn-block" id="submit-btn">Mentés</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    var isFormChanged = false;
    var submitBtn = document.getElementById("submit-btn");
    submitBtn.disabled = true;

    var inputs = document.getElementsByTagName("input");
    for (var i = 0; i < inputs.length; i++) {
        inputs[i].addEventListener("change", function() {
            isFormChanged = true;
            submitBtn.disabled = false;
        });
    }

    submitBtn.addEventListener("click", function() {
        if (!isFormChanged) {
            submitBtn.disabled = true;
        }
    });
</script>