<?php

$username = '';
$password = '';
$postData = [];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = post_data('username');    
    $password = post_data('password');
    
    $login = new Login($username, $password);

    $errors=$login->getUser($username, $password);
    if(empty($errors)) header("Location: /farmshop/");
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