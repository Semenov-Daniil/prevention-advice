<?php

use app\models\Curators;
use app\models\Users;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\CuratorsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Кураторы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="curators-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <? if (!Yii::$app->user->isGuest && Users::findOne(Yii::$app->user->id)->getTitleRoles() == 'Admin'): ?>
        <p>
            <?= Html::a('Создать Куратора', ['create'], ['class' => 'mt-3 btn btn-success']) ?>
        </p>
    <? endif; ?>

    <div class="curators-search">
        <div class="col-lg-6">
            <?php $form = ActiveForm::begin([
                'id' => 'search-curators-form',
                'action' => ['index'],
                'method' => 'get',
                'options' => [
                    'class' => 'd-flex flex-row align-items-end gap-3'
                ]
            ]); ?>
            
            <?= $form->field($searchModel, 'fio', ['options' => ['class' => 'mb-3 flex-fill']])->textInput() ?>
    
            <div class="form-group d-flex gap-1">
                <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary']) ?>
                <?= Html::resetButton('Сбросить', ['class' => 'btn btn-outline-secondary', 'onclick' => 'window.location.replace(window.location.pathname);']) ?>
            </div>
    
            <?php ActiveForm::end(); ?>
        </div>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'fio',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Curators $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
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
