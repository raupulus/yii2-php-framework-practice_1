<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Citas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="citas-form">

    <div>
        <p>
            Próxima cita disponible para <?= $model->fecha ?> a las
            <?= $model->hora ?> horas.
        </p>
    </div>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'fecha')->textInput(['readonly' => true]) ?>

    <?= $form->field($model, 'hora')->textInput(['readonly' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Reservar cita', ['class' => 'btn 
        btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
