<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Curators $model */

$this->title = 'Обновить: ' . $model->fio;
$this->params['breadcrumbs'][] = ['label' => 'Кураторы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->fio, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="curators-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
