<?php

use app\models\Curators;
use app\models\Groups;
use yii\bootstrap5\Html as Bootstrap5Html;
use yii\bootstrap5\ActiveForm;


/** @var yii\web\View $this */
/** @var app\models\AdvicesStudents $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="advice-form">
    <div class="row">   
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin([
                'id' => 'cerate-advice-form',
                'fieldConfig' => [
                    'template' => "{label}\n{input}\n{error}",
                    'labelOptions' => ['class' => 'col-lg-1 col-form-label mr-lg-3'],
                    'inputOptions' => ['class' => 'col-lg-3 form-control'],
                    'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
                ],
            ]); ?>
    
            <?= $form->field($model, 'date')->textInput(['type' => 'date', 'autofocus' => true]) ?>
    
            <div class="form-group">
                <div>
                    <?= Bootstrap5Html::submitButton($btn_title, ['class' => 'btn btn-primary', 'name' => 'create-advice-button']) ?>
                </div>
            </div>
    
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
