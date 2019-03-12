<?php

?>
<?php use yii\bootstrap\ActiveForm;

$form = ActiveForm::begin(); ?>

<?= $form->field($model, 'content')->widget(\yii\redactor\widgets\Redactor::className(),[
    'clientOptions' => [
//        'imageManagerJson' => ['/redactor/upload/image-json'],
//        'imageUpload' => ['/redactor/upload/image'],
//        'fileUpload' => ['/redactor/upload/file'],
        'lang' => 'zh_cn',
        'plugins' => ['clips', 'fontcolor','imagemanager']
    ]
]) ?>
<?= \yii\helpers\Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
<?php ActiveForm::end(); ?>
