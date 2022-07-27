<?php
require_once  'config.php';
require_once  'models/Auth.php';
require_once 'dao/PostDaoMysql.php';

$auth = new Auth($pdo, $base);
$userInfo = $auth->checkToken();
$activeMenu = 'home';

// Paginação
$page = intval(filter_input(INPUT_GET, 'p'));
        if($page < 1){
            $page = 1;
        }


$postDao = new PostDaoMysql($pdo);
$info = $postDao->getHomeFeed($userInfo->id, $page);
$feed = $info['feed'];
$pages = $info['pages'];
$currentPage = $info['currentPage'];





require 'partials/header.php';
require 'partials/menu.php';
?>
<section class="feed mt-10">
  <div class="row">
    <div class="column pr-5">

    <?php require 'partials/feed-editor.php'; ?>

    <?php foreach($feed as $item): ?>
    <?php require 'partials/feed-item.php';?>
    <?php endforeach; ?>

    <div class="feed-pagination">
        <?php for($q=0;$q<$pages;$q++): ?>
            <a class="<?=($q+1==$currentPage)?'active':''?>" href="<?=$base?>/?p=<?=$q+1;?>"><?=$q+1;?></a>
        <?php endfor;?>
    </div>

    </div>
    <div class="column side pl-5">
     <div class="box banners">
        <div class="box-header">
            <div class="box-header-text">Estudos</div>
            <div class="box-header-buttons">
                
            </div>
            </div>
        <div class="box-body">
            <img src="<?=$base;?>/assets/images/mysql.png" />
            <img src="<?=$base;?>/assets/images/php.png" />
        </div>
    </div>
    <div class="box">
        <div class="box-body m-10">
            Dev.Back end - Kauan Torres
        </div>
    </div>
</div>
    </div>
  </div>
</section>
<?php
require 'partials/footer.php';
?>