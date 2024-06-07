<?php

use app\controllers\SiteController;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\AdvicesStudents $model */

$this->title = SiteController::dateFormation($model['advice_date']) . ', ' . $model['fio'];
$this->params['breadcrumbs'][] = ['label' => SiteController::dateFormation($model['advice_date']), 'url' => ['advice/view', 'id' => $model['advices_id']]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="advices-students-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Обновить', ['update', 'id' => $model['id']], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model['id']], [
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
            [
                'attribute' => 'fio',
                'label' => 'ФИО'
            ],

            [
                'attribute' => 'birthday',
                'label' => 'День рождения',
                'format' => ['date', 'php: d.m.Y']
            ],

            [
                'attribute' => 'group',
                'label' => 'Группа',
            ],

            [
                'attribute' => 'curator',
                'label' => 'Куратор',
            ],
            
            [
                'attribute' => 'reason',
                'label' => 'Причина вызова на СП'
            ],
            
            [
                'attribute' => 'result',
                'label' => 'Результат СП'
            ],
            
            [
                'attribute' => 'protocol',
                'label' => 'Протокол'
            ],
            
            [
                'attribute' => 'decree',
                'label' => 'Приказ'
            ],
            
            [
                'attribute' => 'remark',
                'label' => 'Замечание'
            ],
            
            [
                'attribute' => 'reprimand',
                'label' => 'Выговор'
            ],
            
            [
                'attribute' => 'note',
                'label' => 'Примечание'
            ],
            
            [
                'attribute' => 'liquidation_period',
                'label' => 'Срок ликвидации',
            ],
            
            [
                'attribute' => 'memo',
                'label' => 'Служебная записка от куратора'
            ],
        ],
    ]) ?>

</div>
