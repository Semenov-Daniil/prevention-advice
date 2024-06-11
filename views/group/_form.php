<?php

use app\models\Curators;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

/** @var yii\web\View $this */
/** @var app\models\Groups $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="groups-form">
    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(); ?>
        
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        
            <?= $form->field($model, 'curators_id')->label('Куратор')->dropdownList(Curators::find()->select(['fio'])->orderBy(['fio' => SORT_ASC])->indexBy('id')->column(),['prompt'=>'Выберите Куратора']) ?>
        
            <div class="form-group">
                <?= Html::submitButton($btn_title, ['class' => 'btn btn-success']) ?>
            </div>
        
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
