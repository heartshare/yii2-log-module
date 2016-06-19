<?php
/**
 * ErrorSearch class file.
 * @copyright (c) 2014, Galament
 * @license http://www.opensource.org/licenses/bsd-license.php
 */
 
namespace bariew\logModule\models;

use bariew\abstractModule\models\AbstractModelExtender;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Error represents the model behind the search form about `common\modules\log\models\Error`.
 * @mixin Error
 */
class ErrorSearch extends AbstractModelExtender
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'level'], 'integer'],
            [['category', 'prefix', 'message', 'request', 'log_time', 'request'], 'safe'],
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
     * Searches models.
     * @param array $params search params
     * @return \yii\data\ActiveDataProvider dataProvider
     */
    public function search($params = [])
    {
        $t = parent::tableName();
        $query = parent::search();
        $query->orderBy(["$t.log_time" => SORT_DESC]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            $t.'.id' => $this->id,
            $t.'.level' => $this->level,
        ]);

        $query->andFilterWhere(['like', $t.'.category', $this->category])
            ->andFilterWhere(['like', $t.'.prefix', $this->prefix])
            ->andFilterWhere(['like', $t.'.message', $this->message])
        ;
        if ($this->log_time) {
            $query->andWhere("DATE_FORMAT(FROM_UNIXTIME($t.log_time), '%Y-%m-%d') = :logTime")
                ->addParams([':logTime' => $this->log_time]);
        }
        return $dataProvider;
    }
}
