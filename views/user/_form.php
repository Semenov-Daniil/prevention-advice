<?php

use app\models\Groups;
use app\models\Roles;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

/** @var yii\web\View $this */
/** @var app\models\Students $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="students-form">
    <div class="col-lg-5">
        <?php $form = ActiveForm::begin(); ?>
    
        <?= $form->field($model, 'roles_id', ['options' => ['class' => 'form-group flex-1']])->label('Роль')->dropdownList(Roles::find()->select(['title'])->orderBy(['title' => SORT_ASC])->indexBy('id')->column(),['prompt'=>'Выберите Роль']) ?>
    
        <div class="form-group">
            <?= Html::submitButton($btn_title, ['class' => 'btn btn-success']) ?>
        </div>
    
        <?php ActiveForm::end(); ?>
    </div>
</div>
