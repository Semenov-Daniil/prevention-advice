<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Advices $model */

$this->title = 'Создание Совета Профилактики';
$this->params['breadcrumbs'][] = ['label' => 'Советы Профилактики', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="advices-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
