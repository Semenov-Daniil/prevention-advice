<?php

use app\controllers\SiteController;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\AdvicesStudents $model */

$this->title = 'Обновление записи СП ' . SiteController::dateFormation($model->advice_date) . ', ' . $model->fio;
// $this->params['breadcrumbs'][] = ['label' => SiteController::dateFormation($model['advice_date']), 'url' => ['advice/view', 'id' => $model['advices_id']]];
// $this->params['breadcrumbs'][] = ['label' => SiteController::dateFormation($model['advice_date']) . ', ' . $model['fio'], 'url' => ['view', 'id' => $model['id']]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="advices-students-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
