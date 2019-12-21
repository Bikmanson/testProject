<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Customer;

/**
 * CustomerSearch represents the model behind the search form of `app\models\Customer`.
 */
class CustomerSearch extends Customer
{
    public $createdAtRange;

    public $dateStart;

    public $dateEnd;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sex'], 'integer'],
            [['createdAtRange', 'dateStart', 'dateEnd'], 'string'],
            [['login', 'first_name', 'last_name', 'email'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Customer::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if (!empty($this->createdAtRange) && strpos($this->createdAtRange, '-') !== false) {
            list($dateStart, $dateEnd) = explode(' - ', $this->createdAtRange);
            $query->andFilterWhere([
                'between',
                'created_at',
                strtotime($dateStart),
                strtotime($dateEnd) + 86399, //seconds in day - 1 (day end included)
            ]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'sex' => $this->sex
        ]);

        $query->andFilterWhere(['like', 'login', $this->login])
            ->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }
}
