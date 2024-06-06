<?php

use app\models\Students;
use app\controllers\SiteController;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\Advices $model */
/** @var $students */

$this->title = 'Совет Профилактики: ' .  SiteController::dateFormation($model->date);
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="advices-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Обновить дату', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы точно хотите удалить данную запись?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $students,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'fio',
            [
                'attribute' => 'birthday',
                'format' => ['date', 'php:d.m.Y']
            ],
            'reason:ntext',
            'result:ntext',
            'protocol:ntext',
            'decree:ntext',
            'remark:ntext',
            'reprimand:ntext',
            'note:ntext',
            // [
            //     'attribute' => 'liquidation_period',
            //     'value' => function ($data) {
            //         return SiteController::dateFormation($data->liquidation_period);
            //     },
            // ],
            'memo:ntext',
        ],
    ]); ?>

</div>
