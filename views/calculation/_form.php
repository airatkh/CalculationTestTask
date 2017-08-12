<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Calculation */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="calculation-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php //$form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'calculation')->textarea() ?>

    <?php //$form->field($model, 'created_at')->textInput() ?>

    <?php //$form->field($model, 'updated_at')->textInput() ?>

    <?php //$form->field($model, 'deleted_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
