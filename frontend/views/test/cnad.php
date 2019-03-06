<?php
$this->title = '生成考号';
$this->params['breadcrumbs'][] = ['label' => '考试信息管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$form = \yii\bootstrap\ActiveForm::begin();

$list = \frontend\models\Test::find()
    ->select('test_name,test_num')
    ->where(['status'=>2,'grade_num'=>$grade])
    ->indexBy('test_num')
    ->orderBy('test_num desc')
    ->column();

$list[0] = '生成随机考号';

echo $form->field($model,'test_num')
        ->dropDownList($list,['prompt'=>'请选择以下考试成绩生成考号'])->label('选择考试');

echo $form->field($model,'capt')->widget(\yii\captcha\Captcha::className(),[
    'captchaAction'=>'site/captcha',
    'template'=>'<div class="row"><div class="col-lg-2">{input}</div><div class="col-lg-1">{image}</div></div>'
]);
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-success']);
\yii\bootstrap\ActiveForm::end();