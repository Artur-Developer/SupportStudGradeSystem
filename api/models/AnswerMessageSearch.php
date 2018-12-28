<?php

namespace api\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use api\models\AnswerMessage;

/**
 * AnswerMessageSearch represents the model behind the search form of `backend\models\AnswerMessage`.
 */
class AnswerMessageSearch extends AnswerMessage
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'support_user_id'], 'integer'],
            [['answer_message', 'image'], 'safe'],
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
        $query = AnswerMessage::find();

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

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'support_user_id' => $this->support_user_id,
        ]);

        $query->andFilterWhere(['like', 'answer_message', $this->answer_message])
            ->andFilterWhere(['like', 'image', $this->image]);

        return $dataProvider;
    }
}
