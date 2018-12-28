<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AnswerMessage */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="answer-message-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'support_user_id')->textInput() ?>

    <?= $form->field($model, 'answer_message')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'image')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
