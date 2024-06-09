<?php

use yii\helpers\Html;
use app\controllers\SiteController;

/** @var yii\web\View $this */
/** @var app\models\Advices $model */

$this->title = 'Обновить дату';
$this->params['breadcrumbs'][] = ['label' => SiteController::dateFormation($model->date), 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить дату';
?>
<div class="advices-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'btn_title' => 'Обновить'
    ]) ?>

</div>
