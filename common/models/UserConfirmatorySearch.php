<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\UserConfirmatory;

/**
 * UserConfirmatorySearch represents the model behind the search form about `common\models\UserConfirmatory`.
 */
class UserConfirmatorySearch extends UserConfirmatory
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'userID', 'active'], 'integer'],
            [['nationalCard_url', 'birthCertificate_url'], 'safe'],
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
        $query = UserConfirmatory::find();

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
            'active' => $this->active,
        ]);

        $query->andFilterWhere(['like', 'nationalCard_url', $this->nationalCard_url])
            ->andFilterWhere(['like', 'birthCertificate_url', $this->birthCertificate_url]);

        return $dataProvider;
    }
}
