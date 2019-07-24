<?php

namespace app\modules\alertas\models;

use Yii;

/**
 * This is the model class for table "ramas".
 *
 * @property integer $idrama
 * @property string $descrama
 *
 * @property Calendario[] $calendarios
 * @property RamasSubramas[] $ramasSubramas
 * @property Subramas[] $idsubramas
 */
class Ramas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ramas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['descrama'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idrama' => 'Idrama',
            'descrama' => 'Descrama',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalendarios()
    {
        return $this->hasMany(Calendario::className(), ['idrama' => 'idrama']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRamasSubramas()
    {
        return $this->hasMany(RamasSubramas::className(), ['idrama' => 'idrama']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdsubramas()
    {
        return $this->hasMany(Subramas::className(), ['idsubrama' => 'idsubrama'])->viaTable('ramas_subramas', ['idrama' => 'idrama']);
    }
}
