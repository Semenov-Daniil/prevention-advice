<?php

use yii\helpers\Html;
use app\controllers\AppController;

/** @var yii\web\View $this */
/** @var app\models\Advices $model */

$this->title = 'Обновление';
$this->params['breadcrumbs'][] = ['label' => 'Совет Профилактики', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'СП ' .  AppController::dateFormation($model->date), 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="advices-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
