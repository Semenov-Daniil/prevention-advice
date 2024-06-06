<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\controllers\SiteController;
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

    <?= GridView::widget([
        'options' => ['class' => 'd-flex flex-column align-items-center'],
        'dataProvider' => $dataStudents,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'fio',
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
            [
                'attribute' => 'liquidation_period',
                'format' => 'ntext',
                'value' => function ($data) {
                    $result = '';
                    if ($data['liquidation_period']) {
                        $dates = explode("\n", $data['liquidation_period']);
                        foreach ($dates as $date) {
                            $result .= date("d.m.Y", strtotime($date)) . "\n";
                        }
                    }
                    return $result;
                },
            ],
            'memo:ntext',

            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, $dataStudents, $key, $index, $column) {
                    return Url::toRoute(['advice-student/' . $action, 'id' => $dataStudents['id']]);
                }
            ],
        ],
    ]); ?>

    <?=Html::a('Добавить запись', ['advice-student/create', 'advice' => Yii::$app->request->get('id')], ['class' => 'btn btn-primary']);?>
    <?=Html::a('Экспортировать в CSV', ['site/export', 'advice' => Yii::$app->request->get('id')], ['class' => 'btn btn-outline-secondary']);?>


</div>
