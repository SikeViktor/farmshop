<?php

$username = '';
$email = '';
$password = '';
$password_confirm = '';
$postData = [];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {    
    $username = post_data('username');
    $email = post_data('email');
    $password = post_data('password');
    $password_confirm = post_data('password_confirm');
    
    $signup=new Signup($username, $password, $password_confirm, $email);

    $errors=$signup->setUser($username, $password, $password_confirm, $email);
    if(empty($errors)) header("Location: /farmshop/login.php");
}

function post_data($field)
{
    if (!isset($_POST[$field])) {
        return false;
    }
    $data = $_POST[$field];
    return htmlspecialchars(stripslashes(trim($data)));
}

?>