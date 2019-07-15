<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Wagedetail;

/**
 * WagedetailSearch represents the model behind the search form about `common\models\Wagedetail`.
 */
class WagedetailSearch extends Wagedetail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'wage_id', 'fixpercent', 'varpercent', 'startprice', 'endprice'], 'integer'],
            [['date'], 'safe'],
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
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Wagedetail::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'wage_id' => $this->wage_id,
            'fixpercent' => $this->fixpercent,
            'varpercent' => $this->varpercent,
            'date' => $this->date,
            'startprice' => $this->startprice,
            'endprice' => $this->endprice,
        ]);

        return $dataProvider;
    }
}
