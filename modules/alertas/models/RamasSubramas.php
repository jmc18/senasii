<?php

namespace app\modules\alertas\models;

use Yii;

/**
 * This is the model class for table "ramas_subramas".
 *
 * @property integer $idrama
 * @property integer $idsubrama
 *
 * @property Ramas $idrama0
 * @property Subramas $idsubrama0
 */
class RamasSubramas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ramas_subramas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idrama', 'idsubrama'], 'required'],
            [['idrama', 'idsubrama'], 'integer'],
            [['idrama'], 'exist', 'skipOnError' => true, 'targetClass' => Ramas::className(), 'targetAttribute' => ['idrama' => 'idrama']],
            [['idsubrama'], 'exist', 'skipOnError' => true, 'targetClass' => Subramas::className(), 'targetAttribute' => ['idsubrama' => 'idsubrama']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idrama' => 'Idrama',
            'idsubrama' => 'Idsubrama',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdrama0()
    {
        return $this->hasOne(Ramas::className(), ['idrama' => 'idrama']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdsubrama0()
    {
        return $this->hasOne(Subramas::className(), ['idsubrama' => 'idsubrama']);
    }
}
