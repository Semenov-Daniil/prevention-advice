<?php

use app\controllers\SiteController;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\AdvicesStudents $model */
/** @var app\models\Advices $dataAdvice */

$this->title = 'Создание записи';
$this->params['breadcrumbs'][] = ['label' => SiteController::dateFormation($dataAdvice->date), 'url' => ['advice/view', 'id' => $dataAdvice->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="advices-students-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'btn_title' => 'Создать'
    ]) ?>

</div>
