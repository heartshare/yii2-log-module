<?php

namespace bariew\logModule\models;

use bariew\abstractModule\models\AbstractModelExtender;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;


/**
 * ItemSearch represents the model behind the search form about `bariew\logModule\models\Item`.
 *
 * @mixin Item
 */
class ItemSearch extends AbstractModelExtender
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'owner_id', 'user_id'], 'integer'],
            [['event', 'model_name', 'model_id', 'message', 'created_at'], 'safe'],
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
    public function search($params = [])
    {
        $query = parent::search();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]]
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
            'user_id' => $this->user_id,
            'owner_id' => $this->owner_id,
        ]);

        $query->andFilterWhere(['like', 'event', $this->event])
            ->andFilterWhere(['like', 'model_name', $this->model_name])
            ->andFilterWhere(['like', 'model_id', $this->model_id])
            ->andFilterWhere(['like', 'message', $this->message]);
        if ($this->created_at) {
            $query->andWhere("DATE_FORMAT(FROM_UNIXTIME(created_at), '%Y-%m-%d') = :created_at")
                ->addParams([':created_at' => $this->created_at]);
        }
        return $dataProvider;
    }
}
