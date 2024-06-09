<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html as Bootstrap5Html;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Advices $model */

$this->title = 'Создать Совет Профилактики';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="advices-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'btn_title' => 'Создать'
    ]) ?>

</div>
