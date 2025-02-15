<?php

namespace app\modules\expertos\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\expertos\models\Expertos;

/**
 * ExpertosSearch represents the model behind the search form about `app\modules\expertos\models\Expertos`.
 */
class ExpertosSearch extends Expertos
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idexperto'], 'integer'],
            [['nomexperto', 'apepat', 'apemat', 'email', 'telexperto', 'nacionalidad'], 'safe'],
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
        $query = Expertos::find();

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
            'idexperto' => $this->idexperto,
        ]);

        $query->andFilterWhere(['like', 'nomexperto', $this->nomexperto])
            ->andFilterWhere(['like', 'apepat', $this->apepat])
            ->andFilterWhere(['like', 'apemat', $this->apemat])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'telexperto', $this->telexperto])
            ->andFilterWhere(['like', 'nacionalidad', $this->nacionalidad]);

        return $dataProvider;
    }
}
