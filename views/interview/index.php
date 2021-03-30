<?php

use app\models\Interview;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\forms\search\InterviewSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Interviews';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="interview-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Interview', ['join'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'date',
            'first_name',
            'last_name',
            'email:email',
            [
                'attribute' => 'status',
                'filter' => $searchModel->getStatusList(),
                'value' => 'statusName',
            ],
            'employee_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
