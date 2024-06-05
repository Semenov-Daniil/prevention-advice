<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Groups $model */

$this->title = 'Обновить Группу';
$this->params['breadcrumbs'][] = ['label' => 'Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="groups-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
