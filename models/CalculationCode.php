<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "calculation_code".
 *
 * @property integer $id
 * @property integer $calculation_id
 * @property integer $code_id
 *
 * @property Calculation $calculation
 * @property Code $code
 */
class CalculationCode extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'calculation_code';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['calculation_id', 'code_id'], 'required'],
            [['calculation_id', 'code_id'], 'integer'],
            [
                ['calculation_id'],
                'exist', 'skipOnError' => true,
                'targetClass' => Calculation::className(),
                'targetAttribute' => ['calculation_id' => 'id']
            ],
            [
                ['code_id'],
                'exist', 'skipOnError' => true,
                'targetClass' => Code::className(),
                'targetAttribute' => ['code_id' => 'id']
            ],
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
            'calculation_id' => 'Calculation ID',
            'code_id' => 'Code ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalculation()
    {
        return $this->hasOne(Calculation::className(), ['id' => 'calculation_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCode()
    {
        return $this->hasOne(Code::className(), ['id' => 'code_id']);
    }
}
