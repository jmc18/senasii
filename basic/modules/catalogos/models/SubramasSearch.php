<?php

namespace app\modules\catalogos\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\catalogos\models\Subramas;

/**
 * SubramasSearch represents the model behind the search form about `app\modules\catalogos\models\Subramas`.
 */
class SubramasSearch extends Subramas
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idsubrama'], 'integer'],
            [['descsubrama'], 'safe'],
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
        $query = Subramas::find();

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
            'idsubrama' => $this->idsubrama,
        ]);

        $query->andFilterWhere(['like', 'descsubrama', $this->descsubrama]);

        return $dataProvider;
    }
}
