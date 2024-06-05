<?php

use app\models\Advices;
use app\controllers\SiteController;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\AdvicesSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

setlocale(LC_TIME, 'ru_RU.UTF-8');

$this->title = 'Советы Профилактики';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="advices-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать Совет Профилактики', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'date',
                'value' => function ($data) {
                    return SiteController::dateFormation($data->date);
                },
            ],

            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Advices $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
