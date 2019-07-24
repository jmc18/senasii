<?php

namespace app\modules\alertas\models;

use Yii;

/**
 * This is the model class for table "referencias".
 *
 * @property integer $idreferencia
 * @property string $descreferencia
 *
 * @property Calendario[] $calendarios
 * @property CalendarioCalibracion[] $calendarioCalibracions
 * @property Areas[] $idareas
 */
class Referencias extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'referencias';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['descreferencia'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idreferencia' => 'Idreferencia',
            'descreferencia' => 'Descreferencia',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalendarios()
    {
        return $this->hasMany(Calendario::className(), ['idreferencia' => 'idreferencia']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalendarioCalibracions()
    {
        return $this->hasMany(CalendarioCalibracion::className(), ['idreferencia' => 'idreferencia']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdareas()
    {
        return $this->hasMany(Areas::className(), ['idarea' => 'idarea'])->viaTable('calendario_calibracion', ['idreferencia' => 'idreferencia']);
    }
}
