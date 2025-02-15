<?php

namespace app\modules\catalogos\models;

use Yii;

/**
 * This is the model class for table "areas".
 *
 * @property integer $idarea
 * @property string $descarea
 * @property string $cantidad_serie_datos
 * @property CalendarioCalibracion[] $calendarioCalibracions
 * @property Referencias[] $idreferencias
 */
class Areas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'areas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['descarea'], 'string', 'max' => 30],
            [['cantidad_serie_datos'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idarea' => 'Idarea',
            'descarea' => 'Descripción',
            'cantidad_serie_datos' => 'Cantidad de Serie de Datos',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalendarioCalibracions()
    {
        return $this->hasMany(CalendarioCalibracion::className(), ['idarea' => 'idarea']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdreferencias()
    {
        return $this->hasMany(Referencias::className(), ['idreferencia' => 'idreferencia'])->viaTable('calendario_calibracion', ['idarea' => 'idarea']);
    }
}
