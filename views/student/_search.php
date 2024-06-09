<?php

use app\models\Groups;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\StudentsSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="students-search py-3">
    <div class="col-lg-5">
        <?php $form = ActiveForm::begin([
            'id' => 'search-students-form',
            'action' => ['index'],
            'method' => 'get',
            'options' => [
                'class' => 'd-flex flex-column'
            ]
        ]); ?>
        
        <?= $form->field($model, 'fio') ?>

        <?= $form->field($model, 'birthday')->textInput(['type' => 'date']) ?>

        <?= $form->field($model, 'groups_id')->label('Группа')->dropdownList(Groups::find()->select(['title'])->indexBy('id')->column(),['prompt'=>'Выберите Группу']) ?>
    
        <div class="form-group d-flex gap-3">
            <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary']) ?>
            <?= Html::resetButton('Сбросить', ['class' => 'btn btn-outline-secondary', 'onclick' => 'window.location.replace(window.location.pathname);']) ?>
        </div>
    
        <?php ActiveForm::end(); ?>
    </div>
</div>
