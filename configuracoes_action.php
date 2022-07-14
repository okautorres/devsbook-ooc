<?php
require_once  'config.php';
require_once  'models/Auth.php';
require_once 'dao/UserDaoMysql.php';
require 'helpers/UploadHelper.php';

$uploadHelper = new UploadHelper();

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
    //EMAIL
    if($userInfo->email != $email ){ // se o email for diferente do email que mandou 
        if($userDao->findByEmail($email) === false){
            $userInfo->email = $email;
        } else{
            $_SESSION['flash'] = 'Este e-mail já está cadastrado';
            $auth->redirect("/configuracoes.php");
            exit;
        }
    }

    //BIRTHDATE
    $birthdate = explode('/', $birthdate);
    if(count($birthdate) != 3) {
        $_SESSION['flash'] = 'Data de nascimento inválida.';
        $auth->redirect("/configuracoes.php");
        exit;
    } 

    $birthdate = $birthdate[2].'-'.$birthdate[1].'-'.$birthdate[0];
    if(strtotime($birthdate) === false){
        $_SESSION['flash'] = 'Data de nascimento inválida.';
        $auth->redirect("/configuracoes.php");
        exit;
    }

    $userInfo->birthdate = $birthdate;

    //PASSWORD
    if(!empty($password)){
        if($password === $password_confirmation){
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $userInfo->password = $hash;

        } else{

            $_SESSION['flash'] = 'As senhas não coincidem.';
            $auth->redirect("/configuracoes.php");
            exit;

        }

    }

    //Avatar
    if(isset($_FILES['avatar']) && !empty($_FILES['avatar']['tmp_name'])) {
        $newAvatar = $_FILES['avatar'];
    
        $finalImage = $uploadHelper->execute($newAvatar, 200, 200);
    
        $avatarName = md5(time().rand(0,999).'.'.$newAvatar['type']);
        imagejpeg($finalImage, './media/avatars/'.$avatarName, 100);
        $userInfo->avatar = $avatarName;
     
    } 

    //Cover
    if(isset($_FILES['cover']) && !empty($_FILES['cover']['tmp_name'])) {
        $newCover = $_FILES['cover'];
    
        $finalImage = $uploadHelper->execute($newCover, 850, 313);
        $coverName = md5(time().rand(0,999).'.'.$newCover['type']);
        imagejpeg($finalImage, './media/covers/'.$coverName, 100);
        $userInfo->cover = $coverName;
     
    }


    $userDao->update($userInfo);
}

$auth->redirect("/configuracoes.php");
exit;
