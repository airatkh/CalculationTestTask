<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CalculationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Calculations';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="calculation-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Create Calculation', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'name',
            'calculation',
            [
                'attribute'=>'Codes',
                'format'=>'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    $result = [];
                    foreach($model->codes as $code) {
                        $result[] = $code->code;

                    }
                    return \yii\helpers\VarDumper::export($result);
                }
            ],
            'created_at',
        ],
    ]); ?>
</div>
