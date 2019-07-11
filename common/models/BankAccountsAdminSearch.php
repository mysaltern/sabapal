<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\BankAccounts;

/**
 * BankAccountsSearch represents the model behind the search form about `common\models\BankAccounts`.
 */
class BankAccountsAdminSearch extends BankAccounts
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
                [['id', 'status', 'year', 'userID', 'primary', 'month'], 'integer'],
                [['name', 'shaba', 'cartNumber', 'accountNumber'], 'safe'],
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
        $query = BankAccounts::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate())
        {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'year' => $this->year,
            'userID' => $this->userID,
            'primary' => $this->primary,
            'month' => $this->month,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['like', 'shaba', $this->shaba])
                ->andFilterWhere(['like', 'cartNumber', $this->cartNumber])
                ->andFilterWhere(['like', 'accountNumber', $this->accountNumber]);

        return $dataProvider;
    }

}
