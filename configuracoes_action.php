<?php
require_once  'config.php';
require_once  'models/Auth.php';
require_once 'dao/UserDaoMysql.php';

$auth = new Auth($pdo, $base);
$userInfo = $auth->checkToken();

$userDao = new UserDaoMysql($pdo);

$name = filter_input(INPUT_POST, 'name');
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$birthdate = filter_input(INPUT_POST, 'birthdate');
$city = filter_input(INPUT_POST, 'city');
$work = filter_input(INPUT_POST, 'work');
$password = filter_input(INPUT_POST, 'password');
$password_confirmation = filter_input(INPUT_POST, 'password_confirmation');

if($name && $email){
    $userInfo->name = $name;
    $userInfo->city = $city;
    $userInfo->work = $work;

    if($userInfo->email != $email ){ // se o email for diferente do email que mandou 
        if($userDao->findByEmail($email) === false){
            $userInfo->email = $email;
        } else{
            $_SESSION['flash'] = 'Este e-mail já está cadastrado';
            $auth->redirect("/configuracoes.php");
            exit;
        }
    }


    //$userDao->update($userInfo);
}

$auth->redirect("/configuracoes.php");
