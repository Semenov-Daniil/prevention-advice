<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\AdvicesStudents $model */

$this->title = 'Обновление записи: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'СП-Студенты', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="advices-students-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
