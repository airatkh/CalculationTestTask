<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Calculation;

/**
 * CalculationSearch represents the model behind the search form about `app\models\Calculation`.
 */
class CalculationSearch extends Calculation
{
    /**
     * @var string
     */
    public $codeGreaterThan = false;

    /**
     * @var string
     */
    public $codeLessThan = false;

    /**
     * @var string
     */
    public $findByCode = false;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'codeGreaterThan', 'codeLessThan','findByCode'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'findByCode' => 'Find by Code',
            'codeGreaterThan' =>  'Code Greater than or Equal to',
            'codeLessThan' =>  'Code Less than or Equal to'
        ];
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Calculation::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['created_at'=>SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'name', $this->name]);

        if($this->findByCode != false || $this->codeLessThan != false || $this->codeGreaterThan != false ) {
            $query->joinWith('codes');
        }

        if($this->findByCode !==  false) {
            $query->andFilterWhere(['like', 'code.code',  $this->findByCode]);
        }

        if($this->codeGreaterThan !=  false) {
            $query->andFilterWhere(['>=', 'code.code',  $this->codeGreaterThan]);
        }

        if($this->codeLessThan !=  false) {
            $query->andWhere(['<=', 'code.code',  $this->codeLessThan]);
        }

        return $dataProvider;
    }
}
