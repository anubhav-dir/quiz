<?php

namespace app\modules\quiz\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\quiz\models\Answer as AnswerModel;

/**
 * Answer represents the model behind the search form of `app\modules\quiz\models\Answer`.
 */
class Answer extends AnswerModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'question_id', 'state_id', 'created_by_id'], 'integer'],
            [['answer', 'time_taken', 'created_on'], 'safe'],
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
        $query = AnswerModel::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC
                ]
            ]
        ]);

        $this->load($params);
		
		/**
		 *
         * if (!$this->validate()) {
         *    // uncomment the following line if you do not want to return any records when validation fails
         *    // $query->where('0=1');
         *    return $dataProvider;
         * }
         *
         **/

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'question_id' => $this->question_id,
            'time_taken' => $this->time_taken,
            'state_id' => $this->state_id,
            'created_on' => $this->created_on,
            'created_by_id' => $this->created_by_id,
        ]);

        $query->andFilterWhere(['like', 'answer', $this->answer]);

        return $dataProvider;
    }
}
