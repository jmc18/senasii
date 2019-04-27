<?php

namespace app\modules\alertas\models;

use Yii;
use app\modules\ensayos\models\SeguimientoCalibracion; 

/**
 * This is the model class for table "alerta_calibracion".
 *
 * @property integer $idalerta
 * @property integer $idarea
 * @property integer $idreferencia
 * @property integer $idcte
 * @property string $fecha
 * @property string $msjalerta
 * @property string $estatus
 *
 * @property CalendarioCalibracionClientes $idarea0
 */
class AlertaCalibracion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'alerta_calibracion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idarea', 'idreferencia'], 'integer'],
            [['fecha'], 'safe'],
            [['msjalerta'], 'string'],
            [['idcot'], 'string', 'max' => 15],
            [['estatus'], 'string', 'max' => 1],
            [['idcot', 'idarea', 'idreferencia'], 'exist', 'skipOnError' => true, 'targetClass' => SeguimientoCalibracion::className(), 'targetAttribute' => ['idcot' => 'idcot', 'idarea' => 'idarea', 'idreferencia' => 'idreferencia']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idalerta' => 'Idalerta',
            'idcot' => 'Idcot',
            'idarea' => 'Idarea',
            'idreferencia' => 'Idreferencia',
            'fecha' => 'Fecha',
            'msjalerta' => 'Msjalerta',
            'estatus' => 'Estatus',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdcot0()
    {
        return $this->hasOne(SeguimientoCalibracion::className(), ['idcot' => 'idcot', 'idarea' => 'idarea', 'idreferencia' => 'idreferencia']);
    }
}