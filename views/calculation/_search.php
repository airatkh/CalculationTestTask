<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CalculationSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="calculation-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">
            <div class="col-lg-6">
                <h4>Seach by Calculatio name</h4>
                <p><?=  $form->field($model, 'name') ?></p>
                <h4>Seach by Code name</h4>
                <p><?=  $form->field($model, 'findByCode') ?></p>
            </div>
            <div class="col-lg-6">
                <h4>Search by Code...</h4>
                <p><?=  $form->field($model, 'codeGreaterThan') ?></p>
                <h4>Search by Code...</h4>
                <p><?=  $form->field($model, 'codeLessThan') ?></p>
            </div>
        </div>



    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
