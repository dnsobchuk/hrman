<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Assignment */

$this->title = 'Create Assignment';
$this->params['breadcrumbs'][] = ['label' => 'Assigments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="assigment-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
