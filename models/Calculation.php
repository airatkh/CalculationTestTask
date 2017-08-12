<?php

namespace app\models;

use Yii;
use yii\base\Exception;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\VarDumper;

/**
 * This is the model class for table "calculation".
 *
 * @property integer $id
 * @property string $name
 * @property resource $calculation
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 *
 * @property CalculationCode[] $calculationCodes
 * @property Code[] $codes
 */
class Calculation extends \yii\db\ActiveRecord
{

    /**
     * RegEx Expresion for find Code in Calculation text.
     *
     * @const string RegEx.
     * @see getCodeFromCalculation()
     */
    const REGEX_FIND_CODE_IN_CALCULATION = '\'\{([\-\+]?\d+)\}\'';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'calculation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 125],
            [['name','calculation'], 'required'],
            [['calculation'], 'string'],
            [['calculation'], 'isCodeExistInCalculation'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Calculation Name',
            'calculation' => 'Calculation',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalculationCodes()
    {
        return $this->hasMany(CalculationCode::className(), ['calculation_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCodes()
    {
        return $this->hasMany(Code::className(), ['id' => 'code_id'])
            ->via('calculationCodes');
    }

    /**
     * Custom Validation.
     * Check is correct Codes exist in Calculation. Have to exist otherwise validation error.
     *
     * @param $attribute
     * @return array|bool|int
     * @throws Exception
     */
    public function isCodeExistInCalculation($attribute)
    {
        try {
            $codes = [];
            $isFind = preg_match_all(self::REGEX_FIND_CODE_IN_CALCULATION, $this->calculation, $codes);

            if ($isFind === false) { // Some error happened
                $this->addError($attribute, 'Error happened while try to find Code in Calculation.');
                return;
            }
            if ($isFind === 0) {  //Can not find code in calculation
                $this->addError($attribute, 'Can not find valid Code in Calculation.');
            }
        } catch (\Exception $e) {
            $msg = 'Cannot get Code from Calculation. Given date = ' . VarDumper::export($this->getAttributes());
            $msg = $msg . ' System error: ' . VarDumper::export($e->getMessage());
            \Yii::error($msg, __METHOD__);
            $this->addError($attribute, 'System error happened while try to find Code in Calculation. Please try later.');
        }
    }


    /**
     * Extract  Codes from Calculation
     */
    public function getCodeFromCalculation()
    {
        try {
            $codes = [];
            $isFind = preg_match_all(self::REGEX_FIND_CODE_IN_CALCULATION, $this->calculation, $codes);

            if ($isFind === false) { // Some error happened
                return false;
            }
            if ($isFind === 0) {  //Can not find code in calculation
                return 0;
            }
            if ($isFind > 0) {
                return $this->deletePlusFromCodesResult($codes[1]);
            }
        } catch (\Exception $e) {
            $msg = 'Cannot get Code from Calculation. Given date = '. VarDumper::export($this->getAttributes());
            $msg = $msg . ' System error: ' . VarDumper::export($e->getMessage());
            \Yii::error($msg, __METHOD__);
            throw new Exception ();
        }

        $msg = 'Cannot get Code from given Calculation. Given data = ' . VarDumper::export($this->getAttributes());
        \Yii::error($msg, __METHOD__);
        throw new Exception();
    }

    /**
     * Delete all plus in codes result.
     *
     * @param array $codes
     * @return array
     * @throws Exception
     */
    public function deletePlusFromCodesResult(array $codes)
    {
        try {
            foreach($codes as $key=>$code) {
                if($code[0] == '+') {
                    $codes[$key] = str_replace("+", "", $code);
                }
            }
            return $codes;
        } catch (\Exception $e) {
            $msg = 'Cannot delete plus from code result. Given codes = ' . VarDumper::export($codes);
            $msg = $msg . 'Calculation data = ' . VarDumper::export($this->getAttributes());
            $msg = $msg . ' System error: ' . VarDumper::export($e->getMessage());
            \Yii::error($msg, __METHOD__);
            throw new Exception ();
        }
    }
}
