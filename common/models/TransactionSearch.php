<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Transaction;

/**
 * TransactionSearch represents the model behind the search form about `common\models\Transaction`.
 */
class TransactionSearch extends Transaction
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
                [['id', 'userID', 'sourceTypeID', 'sourceID', 'date', 'amount', 'bankLogID', 'status'], 'integer'],
                [['notes', 'cck'], 'safe'],
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
        $userID = \Yii::$app->user->id;

        $query = Transaction::find()->where(['deleted' => 0, 'userID' => $userID])->orderBy('id desc');

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
            'userID' => $this->userID,
            'sourceTypeID' => $this->sourceTypeID,
            'sourceID' => $this->sourceID,
            'date' => $this->date,
            'amount' => $this->amount,
            'bankLogID' => $this->bankLogID,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'notes', $this->notes])
                ->andFilterWhere(['like', 'cck', $this->cck]);

        return $dataProvider;
    }

    public function searchSttlement($params)
    {

        $query = Transaction::find()->where(['deleted' => 0, 'sourceTypeID' => 4]);

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
            'userID' => $this->userID,
            'sourceTypeID' => $this->sourceTypeID,
            'sourceID' => $this->sourceID,
            'date' => $this->date,
            'amount' => $this->amount,
            'bankLogID' => $this->bankLogID,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'notes', $this->notes])
                ->andFilterWhere(['like', 'cck', $this->cck]);

        return $dataProvider;
    }

}
