<?php

namespace app\controllers;

use app\models\CalculationCode;
use app\models\Code;
use Yii;
use app\models\Calculation;
use app\models\CalculationSearch;
use yii\base\Exception;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\filters\VerbFilter;

/**
 * CalculationController implements the CRUD actions for Calculation model.
 */
class CalculationController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Calculation models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CalculationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//        $dataProvider->sort(['defaultOrder' => ['created_at'=>SORT_ASC]]);
//            //'sort'=> ['defaultOrder' => ['topic_order'=>SORT_ASC]]

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Calculation model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @throws Exception
     * @throws \yii\db\Exception
     */
    public function actionCreate()
    {
        $model = new Calculation();
        if ($model->load(Yii::$app->request->post()) && $model->validate()){
            $transaction = Calculation::getDb()->beginTransaction();
            try {
                $codes = $model->getCodeFromCalculation();
                foreach($codes as $code){

                    if($model->save(false) === false){
                        $msg = 'Cannot save relation Calculation. Calculation = ' . VarDumper::export($model->getAttributes());
                        $msg = $msg. ' System error: ' . VarDumper::export($model->getErrors());
                        \Yii::error($msg, __METHOD__);
                        throw new Exception ();
                    }

                    $codeModel = Code::findOne(['code'=>$code]);
                    if($codeModel === null) {
                        $codeModel = new Code();
                        $codeModel->code = $code;
                        if($codeModel->save() === false){
                            $msg = 'Cannot save Code. Calculation = ' . VarDumper::export($model->getAttributes());
                            $msg = $msg . ' Code = ' . VarDumper::export($codeModel->getAttributes());
                            $msg = $msg. ' System error: ' . VarDumper::export($codeModel->getErrors());
                            \Yii::error($msg, __METHOD__);
                            throw new Exception ();
                        }
                    }

                    $calculation_code = new CalculationCode();
                    $calculation_code->code_id = $codeModel->id;
                    $calculation_code->calculation_id = $model->id; //Calculation model
                    if($calculation_code->save() === false){
                        $msg = 'Cannot save relation CalculationCode. Calculation = ' . VarDumper::export($model->getAttributes());
                        $msg = $msg. ' Code = ' . VarDumper::export($codeModel->getAttributes());
                        $msg = $msg. ' System error: ' . VarDumper::export($calculation_code->getErrors());
                        \Yii::error($msg, __METHOD__);
                        throw new Exception ();
                    }
                }

                $transaction->commit();
            } catch (\Exception $e) {
                $transaction->rollBack();
                $msg = 'Cannot create  Calculation. System error: ' . VarDumper::export($e->getMessage());
                \Yii::error($msg, __METHOD__);
                throw new Exception ();
            }

            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
}
