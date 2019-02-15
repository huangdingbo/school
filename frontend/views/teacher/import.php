<?php
$this->title = '导入教师信息';
$this->params['breadcrumbs'][] = ['label' => '教师档案管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'uploader')->fileInput();
echo $form->field($model,'capt')->widget(\yii\captcha\Captcha::className(),[
    'captchaAction'=>'site/captcha',
    'template'=>'<div class="row"><div class="col-lg-2">{input}</div><div class="col-lg-1">{image}</div></div>'
]);
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-success']);
\yii\bootstrap\ActiveForm::end();