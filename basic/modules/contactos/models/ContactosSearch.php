<?php

namespace app\modules\contactos\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\contactos\models\Contactos;

/**
 * ContactosSearch represents the model behind the search form about `app\modules\contactos\models\Contactos`.
 */
class ContactosSearch extends Contactos
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nocontacto'], 'integer'],
            [['nombrecon', 'apepatcon', 'apematcon', 'emailcon', 'telcon'], 'safe'],
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
        $query = Contactos::find();

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
            'nocontacto' => $this->nocontacto,
        ]);

        $query->andFilterWhere(['like', 'nombrecon', $this->nombrecon])
            ->andFilterWhere(['like', 'apepatcon', $this->apepatcon])
            ->andFilterWhere(['like', 'apematcon', $this->apematcon])
            ->andFilterWhere(['like', 'emailcon', $this->emailcon])
            ->andFilterWhere(['like', 'telcon', $this->telcon]);

        return $dataProvider;
    }
}
