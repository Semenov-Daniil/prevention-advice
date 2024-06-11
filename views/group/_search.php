<?php

use app\models\Curators;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\GroupsSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="groups-search">
    <div class="row">
        <div>
            <?php $form = ActiveForm::begin([
                'id' => 'search-groups-form',
                'action' => ['index'],
                'method' => 'get',
                'options' => [
                    'class' => 'd-flex flex-row align-items-end gap-3 flex-wrapp'
                ]
            ]); ?>
            
            <?= $form->field($model, 'title', ['options' => ['class' => 'form-group flex-1']]) ?>
        
            <?= $form->field($model, 'curators_id', ['options' => ['class' => 'form-group flex-1']])->label('Куратор')->dropdownList(Curators::find()->select(['fio'])->orderBy(['fio' => SORT_ASC])->indexBy('id')->column(),['prompt'=>'Выберите Куратора']) ?>
        
            <div class="form-group d-flex gap-1">
                <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary']) ?>
                <?= Html::resetButton('Сбросить', ['class' => 'btn btn-outline-secondary', 'onclick' => 'window.location.replace(window.location.pathname);']) ?>
            </div>
        
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
