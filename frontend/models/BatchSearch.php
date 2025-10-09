<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Batch;

/**
 * BatchSearch represents the model behind the search form of `frontend\models\Batch`.
 */
class BatchSearch extends Batch
{
    // виртуальные поля для поиска по названиям
    public $from_store_name;
    public $to_store_name; 
    public $status_name;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'from_store_id', 'to_store_id', 'batch_status_id', 'created_at'], 'integer'],
            [['batch_number', 'from_store_name', 'to_store_name', 'status_name'], 'safe'],
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
     * @param string|null $formName Form name to be used into `->load()` method.
     *
     * @return ActiveDataProvider
     */
    public function search($params, $formName = null)
    {
        $query = Batch::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'from_store_id' => $this->from_store_id,
            'to_store_id' => $this->to_store_id,
            'batch_status_id' => $this->batch_status_id,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'batch_number', $this->batch_number]);
        
        // Фильтрация по связанным моделям
        $query->andFilterWhere(['like', 'store.name', $this->from_store_name])
              ->andFilterWhere(['like', 'store.name', $this->to_store_name])
              ->andFilterWhere(['like', 'batch_status.name', $this->status_name]);

        return $dataProvider;
    }
}
