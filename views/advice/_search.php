<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\AdvicesSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="advices-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    
    <?= $form->field($model, 'date')->textInput(['type' => 'date']) ?>

    <div class="form-group">
        <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Сбросить', ['class' => 'btn btn-outline-secondary', 'onclick' => 'window.location.replace(window.location.pathname);']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
