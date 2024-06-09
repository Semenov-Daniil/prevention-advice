<?php

use app\models\Groups;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

/** @var yii\web\View $this */
/** @var app\models\AdvicesStudents $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="advices-students-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="d-flex flex-wrapp gap-4 mb-3">
        <?= $form->field($model, 'fio', ['options' => ['class' => 'flex-1']])->label('ФИО Студента') ?>
    
        <?= $form->field($model, 'birthday', ['options' => ['class' => 'flex-1']])->textInput(['type' => 'date']) ?>
    </div>

    <?= $form->field($model, 'groups_id')->label('Группа')->dropdownList(Groups::find()->select(['title'])->indexBy('id')->column(),['prompt'=>'Выберите Группу', 'options' => [$model->groups_id => ['selected' => true]]]) ?>
    
    <?= $form->field($model, 'reason')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'result')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'protocol')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'decree')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'remark')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'reprimand')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'liquidation_period')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'memo')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($btn_title, ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
