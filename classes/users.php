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
}

