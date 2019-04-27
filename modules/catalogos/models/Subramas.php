<?php

namespace app\modules\catalogos\models;

use Yii;

/**
 * This is the model class for table "subramas".
 *
 * @property integer $idsubrama
 * @property string $descsubrama
 *
 * @property Calendario[] $calendarios
 * @property RamasSubramas[] $ramasSubramas
 * @property Ramas[] $idramas
 */
class Subramas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'subramas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['descsubrama'], 'string', 'max' => 80],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idsubrama' => 'Idsubrama',
            'descsubrama' => 'Descripción',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalendarios()
    {
        return $this->hasMany(Calendario::className(), ['idsubrama' => 'idsubrama']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRamasSubramas()
    {
        return $this->hasMany(RamasSubramas::className(), ['idsubrama' => 'idsubrama']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdramas()
    {
        return $this->hasMany(Ramas::className(), ['idrama' => 'idrama'])->viaTable('ramas_subramas', ['idsubrama' => 'idsubrama']);
    }
}
