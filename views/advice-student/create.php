<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\AdvicesStudents $model */

$this->title = 'Создание записи';
$this->params['breadcrumbs'][] = ['label' => 'СП-Студенты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="advices-students-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
