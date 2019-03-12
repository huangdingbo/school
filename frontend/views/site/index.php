<?php

/* @var $this yii\web\View */

$title = \Yii::$app->params['appName'];
$userId = Yii::$app->user->id;
$userModel = \frontend\models\Adminuser::findOne(['id'=>$userId]);
$userName = isset($userModel) ? $userModel->username : '';
$nickName = isset($userModel) ? $userModel->nickname : '';
$lastLogin = isset($userModel) ? $userModel->last_login : '';
$this->title = false;
?>


<div class="site-index">

    <div class="jumbotron">
        <h1>Congratulations!</h1>

        <p class="lead"> <h2><?=$nickName?>用户，你已登录<?=$title?>！！！</h2></p>

        <p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">本系统采用YII2.0</a></p>
    </div>
    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>网站信息</h2>

                <p>域名：<?=$_SERVER['HTTP_HOST'];?></p>
                <p>域名指向地址：<?= $_SERVER['DOCUMENT_ROOT'];?></p>
                <p>入口文件地址：<?=$_SERVER['SCRIPT_FILENAME'];?></p>
                <p>本页URL：<?=Yii::$app->request->getHostInfo().Yii::$app->request->url;?></p>
                <p>基础URL：<?=Yii::$app->request->getHostInfo().Yii::$app->request->getBaseUrl();?></p>
            </div>
            <div class="col-lg-4">
                <h2>运行环境信息</h2>

                <p>PHP版本：<?=phpversion();?></p>
                <p>MYSQL版本：<?= Yii::$app->db->pdo->getAttribute(PDO::ATTR_SERVER_VERSION);?></p>
                <p>nginx版本：<?='1.14.0';?></p>
                <p>Docker版本：<?='17.06.2';?></p>
                <p>数据库操作工具：<?='phpMyAdmin-4.4.12';?></p>
            </div>
            <div class="col-lg-4">
                <h2>服务器信息</h2>

                <p>服务器类型：<?='阿里云轻量级应用服务器';?></p>
                <p>服务器配置：<?='1核CPU 2GB内存 40GB SSD 10Mbps峰值带宽';?></p>
                <p>服务器内网IP：<?= $_SERVER['SERVER_ADDR'];?></p>
                <p>服务器外网IP：<?='47.106.234.70';?></p>
                <p>用户IP：<?=Yii::$app->request->userIP;?></p>
            </div>
        </div>

    </div>
</div>
