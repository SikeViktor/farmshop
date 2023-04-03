<table class="table my-5">
        <thead>
            <tr>
                <th scope="col">Felhasználó azonosító</th>
                <th scope="col">Felhasználónév</th>
                <th scope="col">Email</th>
                <th scope="col">Műveletek</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $users=new Users();
            $result = $users->getUsers();

            $categories=$users->getUserCategories();

            if (isset($_POST["updateUser"])) {
                try {                    
                    $users->updateUser($_POST["user_id"], $_POST["username"], $_POST["email"], $_POST["firstname"], $_POST["lastname"], $_POST["phone"], $_POST["user_img_path"]);
                    header("Refresh: 0");
                } catch (Exception $e) {
                    echo 'Error updating: ' . $e->getMessage();
                }
            }         
            
            
            if (isset($_POST["deleteUser"])) {
                try {
                    $users->deleteUser($_POST["user_id"]);
                    header("Refresh: 0");
                } catch (Exception $e) {
                    echo 'Error deleting: ' . $e->getMessage();
                }
            }            

            foreach ($result as $row) {
            ?>
                <tr>
                    <th scope="row" class="col-2"><?php echo $row["user_id"]; ?></th>
                    <td><?php echo $row["username"]; ?></td>
                    <td><?php echo $row["email"]; ?></td>
                    <td class="col-2">
                        <div class="row">                            
                            <div class="col-4">
                                <button type="button" class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#user-<?php echo $row["user_id"] ?>"><i class="fas fa-cog"></i></button>
                            </div>
                            <div class="col-4">
                                <form action="" method="post">
                                    <input type="hidden" name="user_id" value="<?php echo $row["user_id"]; ?>">
                                    <button type="submit" name="deleteUser" class="btn btn-danger"><i class="fas fa-user-slash"></i></button>
                                </form>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr class="collapse" id="user-<?php echo $row["user_id"] ?>">
                    <td colspan="4">
                        <div class="row justify-content-center">
                            <div class="col-md-10 col-lg-8">
                                <div class="card shadow-sm">
                                    <div class="card-header bg-success text-white text-center">
                                        "<?php echo $row["username"]; ?>" nevű felhasználó
                                    </div>
                                    <div class="card-body text-center">
                                        <form action="" method="post" enctype="multipart/form-data">
                                            <div class="mb-3">
                                                <img src="./images/users/default.png" class="w-50" alt="">
                                                <input class="form-control" type="file" accept="image/png, image/jpeg" name="user_img_path">
                                                <button type="submit" name="uploadImage" class="btn btn-primary btn-block mt-2">Feltöltés</button>
                                            </div>
                                        </form>
                                        <form action="" method="post" enctype="multipart/form-data">
                                            <input type="hidden" name="user_img_path" value="/images/users/default.png">
                                            <input type="hidden" name="user_id" value="<?php echo $row["user_id"]; ?>">
                                            <input type="hidden" name="username" value="<?php echo $row["username"]; ?>">
                                            <div class="mb-3 w-50 mx-auto">
                                                <label for="lastname" class="form-label">Vezetéknév</label>
                                                <input class="form-control" type="text" name="lastname" value="<?php echo $row["lastname"]; ?>">
                                            </div>
                                            <div class="mb-3 w-50 mx-auto">
                                                <label for="firstname" class="form-label">Keresztnév</label>
                                                <input class="form-control" type="text" name="firstname" value="<?php echo $row["firstname"]; ?>">
                                            </div>         
                                            <div class="mb-3 w-50 mx-auto">
                                                <label for="email" class="form-label">Email</label>
                                                <input class="form-control" type="text" name="email" value="<?php echo $row["email"]; ?>">
                                            </div>                                   
                                            <div class="mb-3 w-50 mx-auto">
                                                <label for="phone" class="form-label">Telefonszám</label>
                                                <input class="form-control" type="text" name="phone" value="<?php echo $row["phone"]; ?>">
                                            </div>                                            
                                            <div class="mb-3 w-50 mx-auto">
                                                <label for="user_category_name" class="form-label">Típus</label>
                                                <select class="form-select" name="category">
                                                    <?php
                                                    foreach ($categories as $cat) { ?>
                                                        <option value="<?php echo $cat['user_category_id']; ?>" <?php echo ($cat['user_category_id'] == $row["user_category_id"]) ? "selected" : ""; ?>> <?php echo $cat['user_category_name']; ?></option>;
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="mb-3 w-50 mx-auto">
                                                <label for="user_created_at" class="form-label">Regisztrálás dátuma</label>
                                                <input class="form-control" type="date" name="user_created_at" value="<?php echo $row["created_at"]; ?>" disabled>
                                            </div>
                                            <div class="mb-3 w-50 mx-auto">
                                                <label for="user_modified_at" class="form-label">Utoljára módosítva</label>
                                                <input class="form-control" type="date" name="user_modified_at" value="<?php echo $row["modified_at"]; ?>" disabled>
                                            </div>

                                            <button type="submit" name="updateUser" class="btn btn-primary btn-block">Mentés</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>

            <?php } ?>

        </tbody>
    </table>
