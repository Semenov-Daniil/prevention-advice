<?php

use app\models\Groups;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

/** @var yii\web\View $this */
/** @var app\models\Students $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="students-form">
    <div class="col-lg-5">
        <?php $form = ActiveForm::begin(); ?>
    
        <?= $form->field($model, 'fio')->textInput(['maxlength' => true]) ?>
    
        <?= $form->field($model, 'birthday')->textInput(['type' => 'date']) ?>
    
        <?= $form->field($model, 'groups_id')->label('Группа')->dropdownList(Groups::find()->select(['title'])->indexBy('id')->column(),['prompt'=>'Выберите Группу', 'options' => [$model->groups_id => ['selected' => true]]]) ?>
    
        <div class="form-group">
            <?= Html::submitButton($btn_title, ['class' => 'btn btn-success']) ?>
        </div>
    
        <?php ActiveForm::end(); ?>
    </div>
</div>
