<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Curators $model */

$this->title = 'Создать Куратора';
$this->params['breadcrumbs'][] = ['label' => 'Кураторы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="curators-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
