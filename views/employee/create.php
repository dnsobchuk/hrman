<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $createForm app\forms\EmployeeCreateForm */

$this->title = 'Create Employee';
$this->params['breadcrumbs'][] = ['label' => 'Employees', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = 'Create';
?>
<div class="employee-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($createForm, 'firstName')->textInput() ?>
    <?= $form->field($createForm, 'lastName')->textInput() ?>
    <?= $form->field($createForm, 'email')->textInput() ?>
    <?= $form->field($createForm, 'address')->textarea(['rows' => 5]) ?>

    <div class = "form-group">
        <?= Html::submitButton('Create', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
