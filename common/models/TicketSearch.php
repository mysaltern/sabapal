<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Ticket;

/**
 * TicketSearch represents the model behind the search form about `common\models\Ticket`.
 */
class TicketSearch extends Ticket
    {

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
                [['id', 'userID', 'ticketDepartmentID', 'order', 'status', 'parent', 'date', 'deleted'], 'integer'],
                [['subject', 'description', 'type'], 'safe'],
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
        $query = Ticket::find()->where(['userID' => Yii::$app->user->id, 'deleted' => 0, 'parent' => 0]);

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
            'ticketDepartmentID' => $this->ticketDepartmentID,
            'order' => $this->order,
            'status' => $this->status,
            'parent' => $this->parent,
            'date' => $this->date,
            'deleted' => $this->deleted,
        ]);

        $query->andFilterWhere(['like', 'subject', $this->subject])
                ->andFilterWhere(['like', 'description', $this->description])
                ->andFilterWhere(['like', 'type', $this->type]);

        return $dataProvider;
    }

    }
