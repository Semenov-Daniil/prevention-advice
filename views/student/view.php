<?php

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

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'fio',
            'birthday',
            'groups_title',
        ],
    ]) ?>

    <h1>Советы Профилактики студента</h1>

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
                }
            ],
        ],
    ]); ?>

</div>
