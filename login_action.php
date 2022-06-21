<?php
require_once 'config.php';
require_once 'models/Auth.php';

$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$password = filter_input(INPUT_POST, 'password');

if($email && $password){

    $auth = new Auth($pdo, $base);

    if($auth->validateLogin($email, $password)){
        header("Location:".$base);
        exit;
    }

}
$_SESSION['flash'] = 'Email e/ou senhas errados.';
header("Location:".$base."/login.php");
exit;


?>