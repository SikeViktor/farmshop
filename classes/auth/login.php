<?php

class Login extends Db
{
    private $username;
    private $pwd;

    public function __construct($username, $pwd)
    {
        $this->username = $username;
        $this->pwd = $pwd;
    }

    public function getUser($username, $pwd)
    {
        
        if ($this->emptyInput($username) == true) {
            $errors['username'] = REQUIRED_FIELD_ERROR; 
        }
        if ($this->emptyInput($pwd) == true) {
            $errors['password'] = REQUIRED_FIELD_ERROR; 
        }
        if(!empty($errors)) {            
            return $errors;
        }

        $stmt = $this->connect()->prepare("SELECT * FROM users INNER JOIN user_category ON user_category = user_category_id WHERE username = ?;");

        $stmt->bindParam(1, $username);
        $stmt->execute();

        if ($stmt->rowCount() == 0) {
            $stmt = null;
            $errors['username'] = "Felhasználó nem található!";
            return $errors;
        }

        $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $checkPwd = password_verify($pwd, $user[0]["pwd"]);

        if ($checkPwd == false) {
            $stmt = null;
            $errors['password'] = "Hibás jelszó!";
            return $errors;
        } elseif ($checkPwd == true) {
            $_SESSION["userid"] = $user[0]["user_id"];
            $_SESSION["username"] = $user[0]["username"];
            //echo $_SESSION["userid"] . " " . $_SESSION["username"];
            $stmt = null;            
        }        

        $stmt = null;
    } 

    private function emptyInput($field)
    {
        $result = false;
        if (empty($field)) {
            $result = true;
        } else {
            $result = false;
        }

        return $result;
    }
}
