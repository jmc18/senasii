<?php

namespace app\modules\clientes\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\clientes\models\Clientes;

/**
 * ClientesSearch represents the model behind the search form about `app\modules\clientes\models\Clientes`.
 */
class ClientesSearch extends Clientes
{
	public $username;

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['idcte'], 'integer'],
			[['nomcte', 'email', 'telcte1', 'telcte2', 'dircte', 'edocte', 'pais', 'cpcte', 'sucursal', 'usrcte', 'pwdcte'], 'safe'],
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
		$query = Clientes::find()->with('users');

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
			'idcte' => $this->idcte,
		]);

		$query->andFilterWhere(['like', 'nomcte', $this->nomcte])
			->andFilterWhere(['like', 'email', $this->email])
			->andFilterWhere(['like', 'telcte1', $this->telcte1])
			->andFilterWhere(['like', 'telcte2', $this->telcte2])
			->andFilterWhere(['like', 'dircte', $this->dircte])
			->andFilterWhere(['like', 'edocte', $this->edocte])
			->andFilterWhere(['like', 'pais', $this->pais])
			->andFilterWhere(['like', 'cpcte', $this->cpcte])
			->andFilterWhere(['like', 'sucursal', $this->sucursal])
			->andFilterWhere(['like', 'usrcte', $this->usrcte])
			->andFilterWhere(['like', 'pwdcte', $this->pwdcte])
			->andFilterWhere(['like', 'users.username', $this->username]);		

		return $dataProvider;
	}
}
