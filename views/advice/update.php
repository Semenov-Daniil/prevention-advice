<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Advices $model */

$this->title = 'Обновление Совета Профилактики: ' . $model->date;
$this->params['breadcrumbs'][] = ['label' => 'Советы Профилактики', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->date, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="advices-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
