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
$this->params['breadcrumbs'][] = ['label' => 'Советы Профилактики', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="advices-view">

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

    <?= GridView::widget([
        'dataProvider' => $students,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'students_id',
            'reason:ntext',
            'result:ntext',
            'protocol:ntext',
            'decree:ntext',
            'remark:ntext',
            'reprimand:ntext',
            'note:ntext',
            [
                'attribute' => 'liquidation_period',
                'value' => function ($data) {
                    return SiteController::dateFormation($data->liquidation_period);
                },
            ],
            'memo:ntext',
        ],
    ]); ?>

</div>
