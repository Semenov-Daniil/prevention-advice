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

$this->title = 'Совет Профилактики';

?>
<div class="index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать Совет Профилактики', ['advice/create'], ['class' => 'btn btn-success']) ?>
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
                'controller' => 'advices',
                'urlCreator' => function ($action, Advices $model, $key, $index, $column) {
                    return Url::toRoute(['advice/' . $action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>


</div>
