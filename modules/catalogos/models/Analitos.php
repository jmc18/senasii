<?php

namespace app\modules\catalogos\models;

use Yii;

/**
 * This is the model class for table "analitos".
 *
 * @property integer $idanalito
 * @property string $descparametro
 *
 * @property Calendario[] $calendarios
 */
class Analitos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'analitos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['descparametro'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idanalito' => 'No Analito',
            'descparametro' => 'Descripción del Analito',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalendarios()
    {
        return $this->hasMany(Calendario::className(), ['idanalito' => 'idanalito']);
    }
}
