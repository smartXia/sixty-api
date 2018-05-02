<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <div class="navbar-inverse navbar-fixed-top" style="height: 60px;color: #ffffff">可以在这里搞事情哦。。。</div>
    <div class="container">
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p style="width: 100%;text-align: center" class="pull-left">
            Copyright © 2016-2018 Sixty'Den
            <a href="http://www.miitbeian.gov.cn/state/outPortal/loginPortal.action;jsessionid=-SZfrYcQQRABkmqrjrAVFUmtlKPrDQMkUmrYo-WPX2W21tJf-w6H!893468602" target="_blank">苏ICP备17001302号</a>
        </p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
