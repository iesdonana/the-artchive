<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\UsuariosCompletoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="usuarios-completo-search">

    <h2>+ <?= Yii::t('app', 'Buscar') ?>:</h2>
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="col-sm-6">
        <?= $form->field($model, 'username') ?>
    </div>
    <div class="col-sm-6">
        <?= $form->field($model, 'email') ?>
    </div>

    <div class="form-group text-center">
        <?= Html::submitButton(Yii::t('app', 'Buscar'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Borrar'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
