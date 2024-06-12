<?php

use app\models\Users;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\GroupsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="groups-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'login',
            'role',

            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Users $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                },
                'visibleButtons' => [
                    'update' => function ($model, $key, $index) {
                        return !Yii::$app->user->isGuest && Users::findOne(Yii::$app->user->id)->getTitleRoles() == 'Admin';
                    },
                    'delete' => function ($model, $key, $index) {
                        return !Yii::$app->user->isGuest && Users::findOne(Yii::$app->user->id)->getTitleRoles() == 'Admin';
                    },
                    'view' => function ($model, $key, $index) {
                        return false;
                    },
                ]
            ],
        ],
    ]); ?>


</div>
