<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "code".
 *
 * @property integer $id
 * @property integer $code
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 *
 * @property CalculationCode[] $calculationCodes
 * @property Calculation[] $calculations
 */
class Code extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'code';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code'], 'integer'],
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
            'code' => 'Code',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalculations()
    {
//        return $this->hasMany(CalculationCode::className(), ['code_id' => 'id']);

//        return $this->hasMany(Category::className(), ['id' => 'category_id'])
//             ->viaTable('{{%post_has_category}}', ['post_id' => 'id']);

        return $this->hasMany(Calculation::className(), ['id' => 'id'])
             ->viaTable('{{%calculation_code}}', ['calculation_id' => 'code_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalculationCodes()
    {
        return $this->hasMany(CalculationCode::className(), ['code_id' => 'id']);
    }
}
