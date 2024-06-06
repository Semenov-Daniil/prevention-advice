<?php

use app\models\Curators;
use app\models\Groups;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\AdvicesStudents $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="advices-students-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'fio')->label('ФИО Студента') ?>

    <?= $form->field($model, 'birthday')->textInput(['type' => 'date']) ?>

    <?= $form->field($model, 'groups_id')->label('Группа')->dropdownList(Groups::find()->select(['title'])->indexBy('id')->column(),['prompt'=>'Выберите Группу']) ?>
    
    <?= $form->field($model, 'reason')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'result')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'protocol')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'decree')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'remark')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'reprimand')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'liquidation_period')->textInput(['type' => 'date']) ?>

    <?= $form->field($model, 'memo')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
