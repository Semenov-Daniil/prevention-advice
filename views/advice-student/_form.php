<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\AdvicesStudents $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="advices-students-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'advices_id')->textInput() ?>

    <?= $form->field($model, 'students_id')->textInput() ?>

    <?= $form->field($model, 'reason')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'result')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'protocol')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'decree')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'remark')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'reprimand')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'liquidation_period')->textInput() ?>

    <?= $form->field($model, 'memo')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
