<?php


namespace common\models;


use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Contact;


/**
 * ContactSearch represents the model behind the search form about `app\models\Contact`.
 */
class ContactSearch extends Contact
    {


    /**
     * @inheritdoc
     */
    public function rules()
        {
        return [
                [['id', 'userID', 'gender'], 'integer'],
                [['name', 'lastName', 'address', 'mobile', 'tell', 'postalCode'], 'safe'],
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
        $query = Contact::find();

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
            'gender' => $this->gender,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['like', 'lastName', $this->lastName])
                ->andFilterWhere(['like', 'address', $this->address])
                ->andFilterWhere(['like', 'mobile', $this->mobile])
                ->andFilterWhere(['like', 'tell', $this->tell])
                ->andFilterWhere(['like', 'postalCode', $this->postalCode]);

        return $dataProvider;

        }


    }

