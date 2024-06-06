<?php

use app\models\Curators;
use app\models\Groups;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\AdvicesSearch $model */
/** @var yii\widgets\ActiveForm $form */
/** @var $options */
?>

<div class="advices-search">

    <?php $form = ActiveForm::begin([
        'action' => ['view', ...$options],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'fio')->label('ФИО Cтудента') ?>
    <?= $form->field($model, 'birthday')->textInput(['type' => 'date']) ?>
    <?= $form->field($model, 'group')->dropdownList(Groups::find()->select(['title'])->indexBy('id')->column(),['prompt'=>'Выберите Группу']) ?>
    <?= $form->field($model, 'curator')->dropdownList(Curators::find()->select(['fio'])->indexBy('id')->column(),['prompt'=>'Выберите Куратора']) ?>

    <div class="form-group">
        <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Сбросить', ['class' => 'btn btn-outline-secondary', 'onclick' => "window.location.replace(window.location.pathname + '?id=" . $options['id'] . "');"]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
