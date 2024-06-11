<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\controllers\SiteController;
use app\models\Users;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\Advices $dataAdvice */
/** @var yii\data\ActiveDataProvider $dataStudents */
/** @var app\models\AdvicesStudentsSearch $searchStudents */

$this->title = 'Совет Профилактики: ' . SiteController::dateFormation($dataAdvice->date);
$this->params['breadcrumbs'][] = SiteController::dateFormation($dataAdvice->date);
\yii\web\YiiAsset::register($this);
?>
<div class="advices-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <? if (!Yii::$app->user->isGuest && Users::findOne(Yii::$app->user->id)->getTitleRoles() == 'Admin'): ?>
    <p>
        <?= Html::a('Обновить дату', ['update', 'id' => Yii::$app->request->get('id')], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' =>Yii::$app->request->get('id')], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы точно хотите удалить данную запись?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <? endif; ?>

    <?= DetailView::widget([
        'model' => $dataAdvice,
        'attributes' => [
            [
                'attribute' => 'date',
                'value' => function ($data) {
                    return SiteController::dateFormation($data->date);
                },
            ],
        ],
    ]) ?>

    <?php echo $this->render('_search', ['model' => $searchStudents, 'options' => ['id' => Yii::$app->request->get('id')]]); ?>

    <div>
        <?= GridView::widget([
            'options' => ['class' => 'd-flex flex-column align-items-center'],
            'dataProvider' => $dataStudents,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'fio',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return (!Yii::$app->user->isGuest && Users::findOne(Yii::$app->user->id)->getTitleRoles() == 'Admin') ? Html::a($model['fio'], ['student/view', 'id' => $model['students_id']]) : $model['fio'];
                    },
                ],
                [
                    'attribute' => 'birthday',
                    'format' => ['date', 'php: d.m.Y']
                ],
                'group',
                'curator',
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
                    'urlCreator' => function ($action, $dataStudents, $key, $index, $column) {
                        return Url::toRoute(['advice-student/' . $action, 'id' => $dataStudents['id']]);
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
    
        <? if (!Yii::$app->user->isGuest && Users::findOne(Yii::$app->user->id)->getTitleRoles() == 'Admin'): ?>
            <?=Html::a('Добавить запись', ['advice-student/create', 'advice' => Yii::$app->request->get('id')], ['class' => 'btn btn-primary']);?>
        <? endif; ?>
    
        <?=Html::a('Экспортировать в CSV', ['site/export', 'id' => Yii::$app->request->get('id')], ['class' => 'btn btn-outline-secondary']);?>
    </div>
</div>
