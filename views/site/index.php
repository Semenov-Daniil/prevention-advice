<?php

use app\models\Advices;
use app\controllers\SiteController;
use app\models\Users;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\AdvicesSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Совет Профилактики';

?>
<div class="index">

    <h1><?= Html::encode($this->title) ?></h1>

    <? if (!Yii::$app->user->isGuest && Users::findOne(Yii::$app->user->id)->getTitleRoles() == 'Admin'): ?>
        <p>
            <?= Html::a('Создать Совет Профилактики', ['advice/create'], ['class' => 'mt-3 btn btn-success']) ?>
        </p>
    <? endif; ?>

    <div class="advices-search">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin([
                'id' => 'search-advice-form',
                'action' => ['index'],
                'method' => 'get',
                'options' => [
                    'class' => 'd-flex flex-row align-items-end gap-3'
                ]
            ]); ?>
            
            <?= $form->field($searchModel, 'date', ['options' => ['class' => 'mb-3 flex-fill']])->label('Найти по дате')->textInput(['type' => 'date']) ?>
    
            <div class="form-group d-flex gap-3">
                <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary']) ?>
                <?= Html::resetButton('Сбросить', ['class' => 'btn btn-outline-secondary', 'onclick' => 'window.location.replace(window.location.pathname);']) ?>
            </div>
    
            <?php ActiveForm::end(); ?>
        </div>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'attribute' => 'date',
                'value' => function ($data) {
                    return SiteController::dateFormation($data->date);
                },
            ],

            [
                'class' => ActionColumn::className(),
                'controller' => 'advices',
                'urlCreator' => function ($action, Advices $model, $key, $index, $column) {
                    return Url::toRoute(['advice/' . $action, 'id' => $model->id]);
                },
                'visibleButtons' => [
                    'update' => function ($model, $key, $index) {
                        return !Yii::$app->user->isGuest && Users::findOne(Yii::$app->user->id)->getTitleRoles() == 'Admin';
                    },
                    'delete' => function ($model, $key, $index) {
                        return !Yii::$app->user->isGuest && Users::findOne(Yii::$app->user->id)->getTitleRoles() == 'Admin';
                    },
                ]
            ],
        ],
    ]); ?>


</div>
