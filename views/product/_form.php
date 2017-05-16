<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Product */
/* @var $form yii\widgets\ActiveForm */

$formArgs = ['options' => ['enctype' => 'multipart/form-data', 'data-pjax' => true, 'id' => $model->isNewRecord?'product_create':'product_update'], 'enableAjaxValidation' => false,
    'enableClientValidation' => true,];
if (isset($action)) {
    $formArgs['action'] = $action;
}


?>

<div class="product-form">
    <?= Html::beginTag('div',['id' => '_form_product'.($model->isNewRecord?'_create':'_update')]) ?>
    <?php $form = ActiveForm::begin($formArgs); ?>

    <?= $form->field($model, 'imageFiles')->fileInput() ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success product_submit' : 'btn btn-primary product_submit']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?= Html::endTag('div') ?>

</div>
