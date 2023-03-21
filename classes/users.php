<?php

class Users extends Db
{

    public function getUserById($user_id)
    {
        try {
            $stmt = $this->connect()->prepare("SELECT * FROM users INNER JOIN user_category ON user_category=user_category_id WHERE user_id = ?");
            $stmt->bindParam(1, $user_id);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            return $user;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function getUsers()
    {
        try {
            $stmt = $this->connect()->prepare("SELECT * FROM users INNER JOIN user_category ON user_category=user_category_id");
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            return $user;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function updateUser($user_id, $username, $email, $firstname, $lastname, $phone, $img_path)
    {
        try {
            $stmt = $this->connect()->prepare("UPDATE users
            SET username = ?, email = ?, firstname = ?, lastname = ?, phone = ?, img_path = ?, modified_at = CURRENT_TIMESTAMP()
            WHERE user_id = ?");

            if (!$stmt->execute(array($username, $email, $firstname, $lastname, $phone, $img_path, $user_id))) {
                $stmt = null;
                header("location: ../index.php?error=stmtfailed");
                exit();
            }
            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}
