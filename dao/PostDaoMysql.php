<?php
require_once 'models/Post.php';
require_once 'dao/UserRelationDaoMysql.php';
require_once 'dao/UserDaoMysql.php';
require_once 'dao/PostLikeDaoMysql.php';

class PostDaoMysql implements PostDao{
    private $pdo;

    public function __construct(PDO $driver){
        $this->pdo = $driver;
    }
    
    public function insert(Post $p){
        $sql = $this->pdo->prepare('INSERT INTO posts (
            id_user, type, created_at, body
        ) VALUES (
            :id_user, :type, :created_at, :body
        )');

        $sql->bindValue(':id_user', $p->id_user);
        $sql->bindValue(':type', $p->type);
        $sql->bindValue(':created_at', $p->created_at);
        $sql->bindValue(':body', $p->body);
        $sql->execute();
    }

    public function getUserFeed($id_user){
        $array = [];

        // 1. Pegar os posts ordenado por data
        $sql = $this->pdo->prepare("SELECT * FROM posts
         WHERE id_user = :id_user
         ORDER BY created_at DESC
         ");
        $sql->bindValue(':id_user', $id_user);
        $sql->execute();


         if($sql->rowCount() > 0){
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);
            // 2. Transformar o resultado em objetos
            $array = $this->_postListToObject($data, $id_user);
         }

         return $array;
    }

    public function getHomeFeed($id_user){
        $array = [];
        // FAZER FEED
        // 1. Lista dos seguidores que eu sigo
        $urDao = new UserRelationDaoMysql($this->pdo);
        $userList = $urDao->getFollowing($id_user);
        $userList[] = $id_user;


        // 2. Pegar os posts ordenado por data
        $sql = $this->pdo->query("SELECT * FROM posts
         WHERE id_user IN (".implode(',', $userList).")
         ORDER BY created_at DESC
         ");
         if($sql->rowCount() > 0){
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);
            // 3. Transformar o resultado em objetos
            $array = $this->_postListToObject($data, $id_user);
         }

         return $array;
    }

    public function getPhotosFrom($id_user){
        $array = [];

        $sql = $this->pdo->prepare("SELECT * FROM posts
        WHERE id_user = :id_user AND TYPE = 'photo'
        ORDER BY created_at DESC
        ");
        $sql->bindValue(':id_user', $id_user);
        $sql->execute();

        if($sql->rowCount() > 0){
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);
            $array = $this->_postListToObject($data, $id_user);
        }

        return $array;
    }

    private function _postListToObject($post_list, $id_user){
        $posts = [];
        $userDao = new UserDaoMysql($this->pdo);
        $postLikeDao = new PostLikeDaoMysql($this->pdo);

        foreach($post_list as $post_item){
            $newPost = new Post();
            $newPost->id = $post_item['id'];
            //$newPost->id_user = $post_item['id_user']; não precisa pois já pega no UserDao
            $newPost->type = $post_item['type'];
            $newPost->created_at = $post_item['created_at'];
            $newPost->body = $post_item['body'];
            $newPost->mine = false;

            if($post_item['id_user'] == $id_user){
                $newPost->mine = true;
            }

            // Pegando informações adicionais do úsuario(foto, nome)
            $newPost->user = $userDao->findById($post_item['id_user']);


            // Informações de like
            $newPost->likeCount = $postLikeDao->getLikeCount($newPost->id);
            $newPost->liked = $postLikeDao->isLiked($newPost->id, $id_user);



            // Informações sobre comentários
            $newPost->comments = [];


            $posts[] = $newPost;
        }

        return $posts;
    }

}