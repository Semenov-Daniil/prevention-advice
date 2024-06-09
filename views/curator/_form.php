<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

/** @var yii\web\View $this */
/** @var app\models\Curators $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="curators-form">
    <div class="col-lg-5">
        <?php $form = ActiveForm::begin(); ?>
    
        <?= $form->field($model, 'fio')->textInput(['maxlength' => true, 'autofocus' => true]) ?>
    
        <div class="form-group">
            <?= Html::submitButton($btn_title, ['class' => 'btn btn-success']) ?>
        </div>
    
        <?php ActiveForm::end(); ?>
    </div>
</div>
