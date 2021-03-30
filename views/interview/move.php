<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Interview */
/* @var $moveForm app\forms\InterviewMoveForm */

$this->title = 'Reject Interview: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Interviews', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Move';
?>
<div class="interview-move">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($moveForm, 'date')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Move', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
