<?php

class Signup extends Db
{
    private $uid;
    private $pwd;
    private $pwdRepeat;
    private $email;  

    public $errors = [];

    public function __construct($uid, $pwd, $pwdRepeat, $email)
    {
        $this->uid = $uid;
        $this->pwd = $pwd;
        $this->pwdRepeat = $pwdRepeat;
        $this->email = $email;
    }   

    public function setUser($uid, $pwd, $pwdRepeat, $email)
    {
        $stmt = $this->connect()->prepare("INSERT INTO users (username, pwd, email) VALUES (?, ?, ?);");

        $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

        if ($this->emptyInput($uid) == false) {
            $errors['username'] = REQUIRED_FIELD_ERROR;            
        }
        if ($this->emptyInput($email) == false) {
            $errors['email'] = REQUIRED_FIELD_ERROR;            
        }
        if ($this->emptyInput($pwd) == false) {
            $errors['password'] = REQUIRED_FIELD_ERROR;            
        }  
        if ($this->emptyInput($pwdRepeat) == false) {
            $errors['password_confirm'] = REQUIRED_FIELD_ERROR;            
        }         
        if(!empty($errors)) {            
            return $errors;
        }

        if ($this->invalidUsername() == false) {
            $errors['username'] = "Speciális karaktert nem tartalmazhat!"; 
            return $errors;           
        }
        if ($this->invalidEmail() == false) {
            $errors['email'] = "Helyes email címet adj meg!";
            return $errors;             
        }
        if ($this->pwdMatch() == false) {
            $errors['password_confirm'] = "Jelszavak nem egyeznek!";
            return $errors;             
        }
        if ($this->uidTakenCheck() == false) {
            $errors['password_username'] = "Felhasználónév már foglalt!";
            return $errors;             
        }        

        if (!$stmt->execute(array($uid, $hashedPwd, $email))) {
            $stmt = null;
            header("location: ../index.php?error=stmtfailed");
            exit();
        }

        $stmt = null;
    }

    public function checkUser($uid, $email)
    {
        $stmt = $this->connect()->prepare("SELECT username FROM users WHERE username = ? OR email = ?;");

        if (!$stmt->execute(array($uid, $email))) {
            $stmt = null;
            header("location: ../index.php?error=stmtfailed");
            exit();
        }

        $resultCheck = false;
        if ($stmt->rowCount() > 0) {
            $resultCheck = false;
        } else {
            $resultCheck = true;
        }

        return $resultCheck;
    }

    private function emptyInput($field)
    {
        $result = false;
        if (empty($field)) {
            $result = false;
        } else {
            $result = true;
        }

        return $result;
    }

    private function invalidUsername()
    {
        $result = false;
        if (!preg_match("/^[a-zA-Z0-9]*$/", $this->uid)) {
            $result = false;
        } else {
            $result = true;
        }

        return $result;
    }

    private function invalidEmail()
    {
        $result = false;
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $result = false;
        } else {
            $result = true;
        }

        return $result;
    }

    private function pwdMatch()
    {
        $result = false;
        if ($this->pwd !== $this->pwdRepeat) {
            $result = false;
        } else {
            $result = true;
        }

        return $result;
    }

    private function uidTakenCheck()
    {
        $result = false;
        if (!$this->checkUser($this->uid, $this->email)) {
            $result = false;
        } else {
            $result = true;
        }

        return $result;
    }
    
}
