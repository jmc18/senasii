<?php

namespace app\modules\catalogos\models\areas;

use Yii;

/**
 * This is the model class for table "areas".
 *
 * @property integer $idarea
 * @property string $descarea
 *
 * @property CalendarioCalibracion[] $calendarioCalibracions
 * @property Referencias[] $idreferencias
 * @property SeccionesFormularioCalibracion[] $seccionesFormularioCalibracions
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
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idarea' => 'Idarea',
            'descarea' => 'Descarea',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSeccionesFormularioCalibracions()
    {
        return $this->hasMany(SeccionesFormularioCalibracion::className(), ['idarea' => 'idarea']);
    }
}
