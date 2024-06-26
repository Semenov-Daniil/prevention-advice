<?php

use app\models\Curators;
use app\models\Groups;
use app\models\Users;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\AdvicesSearch $model */
/** @var yii\widgets\ActiveForm $form */
/** @var $options */
?>

<div class="advices-search py-3">
    <div class="row">
        <div class="">
            <?php $form = ActiveForm::begin([
                'action' => ['view', ...$options],
                'method' => 'get',
                'options' => [
                    'class' => 'd-flex flex-column'
                ]
            ]); ?>
        
            <div class="d-flex flex-wrap gap-4">
                <?= $form->field($model, 'fio', ['options' => ['class' => 'form-group flex-1']])->label('ФИО Cтудента') ?>
    
                <?= $form->field($model, 'birthday', ['options' => ['class' => 'form-group flex-1']])->textInput(['type' => 'date']) ?>
            </div>

            <div class="d-flex flex-wrap gap-4">
                <?= $form->field($model, 'group', ['options' => ['class' => 'form-group flex-1']])->dropdownList(Groups::find()->select(['title'])->orderBy(['title' => SORT_ASC])->indexBy('id')->column(),['prompt'=>'Выберите Группу']) ?>
    
                <?= $form->field($model, 'curator', ['options' => ['class' => 'form-group flex-1']])->dropdownList(Curators::find()->select(['fio'])->orderBy(['fio' => SORT_ASC])->indexBy('id')->column(),['prompt'=>'Выберите Куратора']) ?>
            </div>
        
            <div class="d-flex justify-content-between">
                <div class="form-group">
                    <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary']) ?>
                    <?= Html::resetButton('Сбросить', ['class' => 'btn btn-outline-secondary', 'onclick' => "window.location.replace(window.location.pathname + '?id=" . $options['id'] . "');"]) ?>
                </div>
    
                <div class="form-group">
                    <? if (!Yii::$app->user->isGuest && Users::findOne(Yii::$app->user->id)->getTitleRoles() == 'Admin'): ?>
                        <?=Html::a('Добавить запись', ['advice-student/create', 'advice' => Yii::$app->request->get('id')], ['class' => 'btn btn-success']);?>
                    <? endif; ?>
                
                    <?=Html::a('Экспортировать в CSV', ['site/export', 'id' => Yii::$app->request->get('id')], ['class' => 'btn btn-outline-secondary']);?>
                </div>
            </div>
        
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
