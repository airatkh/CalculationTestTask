<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Calculation */

$this->title = 'Create Calculation';
$this->params['breadcrumbs'][] = ['label' => 'Calculations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="calculation-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
