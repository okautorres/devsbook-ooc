<?php
    require_once 'config.php';
    require_once 'models/Auth.php';
    require_once 'dao/PostDaoMysql.php';
    require_once 'helpers/UploadHelper.php';

    $uploadHelper = new UploadHelper();


    $auth = new Auth($pdo, $base);
    $userInfo = $auth->checkToken();


    $array = ['error' => ''];

    $postDao = new PostDaoMysql($pdo);


    if(isset($_FILES['photo']) && !empty($_FILES['photo']['tmp_name'])) {
        $photo = $_FILES['photo'];

        if(in_array($photo['type'], ['image/jpeg', 'image/jpg', 'image/png'])) {
            
            $finalImage = $uploadHelper->execute($photo, 800, 800);
        
            $photoName = md5(time().rand(0,999).'.'.$photo['type']);
            imagejpeg($finalImage, './media/uploads/'.$photoName);

            $newPost = new Post();
            $newPost->id_user = $userInfo->id;
            $newPost->type = 'photo';
            $newPost->created_at = date('Y-m-d H:i:s');
            $newPost->body = $photoName;

            $postDao->insert($newPost);

        } else {
            $array['error'] = 'Arquivo não suportado (jpeg ou png)';
        }


    } else{
        $array['error'] = 'Nenhuma imagem enviada';
    }
    
    header("Content-Type: application/json");
    echo json_encode($array);
    exit;