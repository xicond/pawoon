<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Product */
/* @var $form yii\widgets\ActiveForm */

$formArgs = ['options' => ['enctype' => 'multipart/form-data', 'data-pjax' => true]];
if (isset($action)) {
    $formArgs['action'] = $action;
}


?>

<div class="product-form">
    <?php yii\widgets\Pjax::begin(['id' => '_form_product']) ?>
    <?php $form = ActiveForm::begin($formArgs); ?>

    <?= $form->field($model, 'imageFiles')->fileInput() ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?php yii\widgets\Pjax::end() ?>

</div>
