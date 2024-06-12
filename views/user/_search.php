<?php

use app\models\Roles;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\UsersSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="users-search">
    <div class="row">
        <div>
            <?php $form = ActiveForm::begin([
                'id' => 'users-groups-form',
                'action' => ['index'],
                'method' => 'get',
                'options' => [
                    'class' => 'd-flex flex-row align-items-end gap-3 flex-wrapp'
                ]
            ]); ?>
            
            <?= $form->field($model, 'login', ['options' => ['class' => 'form-group flex-1']]) ?>
        
            <?= $form->field($model, 'roles_id', ['options' => ['class' => 'form-group flex-1']])->label('Роль')->dropdownList(Roles::find()->select(['title'])->orderBy(['title' => SORT_ASC])->indexBy('id')->column(),['prompt'=>'Выберите Роль']) ?>
        
            <div class="form-group d-flex gap-1">
                <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary']) ?>
                <?= Html::resetButton('Сбросить', ['class' => 'btn btn-outline-secondary', 'onclick' => 'window.location.replace(window.location.pathname);']) ?>
            </div>
        
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
