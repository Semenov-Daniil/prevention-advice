<?php

use app\controllers\SiteController;
use app\models\Groups;
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

    <? if ($attention): ?>
        <div class="d-flex flex-column">
            <h3 class="attention-text my-3">Внимание! Данный студент уже записан на Совет Профилактики!</h3>
            <p class="my-3 col-lg-5">Студент <?= $model->fio ?> из группы <?= Groups::findOne($model->groups_id)->title ?>, уже записан на Совет Профилактики <?= SiteController::dateFormation($dataAdvice->date) ?>. Посмотреть данную запись можно по этой <?= Html::a('ссылке', ['advice-student/view', 'id' => $advice_student]) ?>.</p>
    
            <div class="mt-3">
                <?= Html::a('Перезаписать', ['advice-student/update', 'id' => $advice_student], ['class' => 'btn btn-success']) ?>
                <?= Html::a('Дополнить запись', ['advice-student/adding', 'id' => $advice_student, 'advice_id' => $dataAdvice->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Отмена', ['advice-student/create', 'advice' => $dataAdvice->id], ['class' => 'btn btn-danger']) ?>
            </div>
        </div>
    <? else: ?>
        <?= $this->render('_form', [
            'model' => $model,
            'btn_title' => 'Создать'
        ]) ?>
    <? endif; ?>

</div>
