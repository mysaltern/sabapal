<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\InternalPay;

/**
 * InternalPaySearch represents the model behind the search form about `common\models\InternalPay`.
 */
class InternalPaySearch extends InternalPay
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'userID', 'website_categoryID', 'active', 'deleted', 'date'], 'integer'],
            [['website_name', 'website_url', 'customer_tell', 'website_desc', 'ip', 'private_code'], 'safe'],
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
        $query = InternalPay::find();

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
            'userID' => $this->userID,
            'website_categoryID' => $this->website_categoryID,
            'active' => $this->active,
            'deleted' => $this->deleted,
            'date' => $this->date,
        ]);

        $query->andFilterWhere(['like', 'website_name', $this->website_name])
            ->andFilterWhere(['like', 'website_url', $this->website_url])
            ->andFilterWhere(['like', 'customer_tell', $this->customer_tell])
            ->andFilterWhere(['like', 'website_desc', $this->website_desc])
            ->andFilterWhere(['like', 'ip', $this->ip])
            ->andFilterWhere(['like', 'private_code', $this->private_code]);

        return $dataProvider;
    }
}
