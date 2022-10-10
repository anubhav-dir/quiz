<?php
namespace app\modules\quiz\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\quiz\models\Subject as SubjectModel;

/**
 * Subject represents the model behind the search form of `app\modules\quiz\models\Subject`.
 */
class Subject extends SubjectModel
{

    /**
     *
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                [
                    'id',
                    'state_id',
                    'updated_by_id'
                ],
                'integer'
            ],
            [
                [
                    'subject',
                    'description',
                    'created_on',
                    'created_by_id',
                    'updated_on'
                ],
                'safe'
            ]
        ];
    }

    /**
     *
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
        $query = SubjectModel::find()->alias('s')->joinwith('createdBy as c');

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
         * if (!$this->validate()) {
         * // uncomment the following line if you do not want to return any records when validation fails
         * // $query->where('0=1');
         * return $dataProvider;
         * }
         */

        // grid filtering conditions
        $query->andFilterWhere([
            's.id' => $this->id,
            's.state_id' => $this->state_id,
            's.created_on' => $this->created_on,
            's.updated_on' => $this->updated_on,
            's.updated_by_id' => $this->updated_by_id
        ]);

        $query->andFilterWhere([
            'like',
            's.subject',
            $this->subject
        ])
            ->andFilterWhere([
            'like',
            'c.full_name',
            $this->created_by_id
        ])
            ->andFilterWhere([
            'like',
            's.description',
            $this->description
        ]);

        return $dataProvider;
    }
}
