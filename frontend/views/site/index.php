<?php

/* @var $this yii\web\View */

$this->title = false;
$title = \Yii::$app->params['appName'];
$userId = Yii::$app->user->id;
$userModel = \frontend\models\Adminuser::findOne(['id'=>$userId]);
$userName = isset($userModel) ? $userModel->username : '';
$nickName = isset($userModel) ? $userModel->nickname : '';
$lastLogin = isset($userModel) ? $userModel->last_login : '';
$list = array(
                '域名' => $_SERVER['HTTP_HOST'],
                '域名指向地址' => $_SERVER['DOCUMENT_ROOT'],
                '入口文件地址' => $_SERVER['SCRIPT_FILENAME'],
                '本页URL' => Yii::$app->request->getHostInfo().Yii::$app->request->url,
                '基础URL' => Yii::$app->request->getHostInfo().Yii::$app->request->getBaseUrl(),
                '用户IP' => Yii::$app->request->userIP,
                '服务器内网IP' => $_SERVER['SERVER_ADDR'],
                '服务器外网IP' => '47.106.234.70',
                'PHP版本' => phpversion(),
                'MYSQL版本' => Yii::$app->db->pdo->getAttribute(PDO::ATTR_SERVER_VERSION),
                'nginx版本' => '1.14.0',
    );
$i = 0;
?>
<style>
    .table-responsive{
        width: 800px;
        margin: 0 auto;
    }
</style>
<div class="site-index">

    <div class="jumbotron">
        <h2><?=$nickName?>用户，你已登录<?=$title?>！！！</h2>
    </div>

    <div class="body-content">
        <div class="table-responsive">
            <table class="table">
                <?php foreach ($list as $key => $item){?>

                    <tr>
                        <td><?=$key?></td>
                        <td><?=$item?></td>
                    </tr>

                <?php }?>

            </table>
        </div>
    </div>
</div>
