<?php

use app\models\Users;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Students $model */
/** @var app\models\AdvicesStudents $dataProvider */

$this->title = $model->fio;
$this->params['breadcrumbs'][] = ['label' => 'Студенты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="students-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <? if (!Yii::$app->user->isGuest && Users::findOne(Yii::$app->user->id)->getTitleRoles() == 'Admin'): ?>
        <p>
            <?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Вы точно хотите удалить данную запись?',
                    'method' => 'post',
                ],
            ]) ?>
        </p>
    <? endif; ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'fio',
            [      
                'label' => 'День рождения',
                'value' => date('d.m.Y', strtotime($model->birthday)),
            ],
            'groups_title',
        ],
    ]) ?>

    <h1 class="my-3">Советы Профилактики студента</h1>

    <?= GridView::widget([
        'options' => ['class' => 'd-flex flex-column align-items-center'],
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'date',
                'format' => ['raw'],
                'value' => function ($model) {
                    return \yii\helpers\Html::a(date_format(date_create($model['date']), 'd.m.Y'), ['advice/view', 'id' => $model['advices_id']]);
                },
            ],
            'reason:ntext',
            'result:ntext',
            'protocol:ntext',
            'decree:ntext',
            'remark:ntext',
            'reprimand:ntext',
            'note:ntext',
            'liquidation_period:ntext',
            'memo:ntext',

            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, $dataProvider, $key, $index, $column) {
                    return Url::toRoute(['advice-student/' . $action, 'id' => $dataProvider['id']]);
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
