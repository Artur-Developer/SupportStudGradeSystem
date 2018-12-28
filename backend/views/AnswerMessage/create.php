<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AnswerMessage */

$this->title = 'Create Answer Message';
$this->params['breadcrumbs'][] = ['label' => 'Answer Messages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="answer-message-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
