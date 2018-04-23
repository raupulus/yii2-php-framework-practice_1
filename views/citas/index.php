<?php

use app\models\Citas;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CitasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Citas del usuario '.Yii::$app->user->identity->nombre;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="citas-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Nueva Cita', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div>
        <?php
        $model = Citas::citaPendiente()->one();
        ?>

        <?php if ($model): ?>
        <h3>Cita pendiente</h3>

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'fecha',
                'hora',
            ],
        ]) ?>

        <?php else: ?>
        <h3>No tienes citas pendientes</h3>
        <?php endIf ?>

    </div>

    <div>
        <h3>Citas del pasado</h3>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'fecha:date',
            'hora:time',
            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
