<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $joinForm app\forms\InterviewJoinForm */

$this->title = 'Join to Interview';
$this->params['breadcrumbs'][] = ['label' => 'Interviews', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = 'Join';
?>
<div class="interview-join">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($joinForm, 'date')->textInput() ?>
    <?= $form->field($joinForm, 'firstName')->textInput() ?>
    <?= $form->field($joinForm, 'lastName')->textInput() ?>
    <?= $form->field($joinForm, 'email')->textInput() ?>

    <div class = "form-group">
        <?= Html::submitButton('Join', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
