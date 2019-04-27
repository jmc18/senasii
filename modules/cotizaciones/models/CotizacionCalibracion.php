<?php

namespace app\modules\cotizaciones\models;

use Yii;
use app\modules\calendarios\models\CalendarioCalibracion;
use app\modules\ensayos\models\SeguimientoCalibracion;


/**
 * This is the model class for table "cotizacion_calibracion".
 *
 * @property integer $idcot
 * @property integer $idarea
 * @property integer $idreferencia
 * @property double $costo
 *
 * @property CalendarioCalibracion $idarea0
 * @property Cotizaciones $idcot0
 */
class CotizacionCalibracion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cotizacion_calibracion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idcot', 'idarea', 'idreferencia'], 'required'],
            [['idarea', 'idreferencia', 'descargar'], 'integer'],
            [['costo'], 'number'],
            [['aceptado'], 'safe'],
            [['idcot'], 'string', 'max' => 15],
            [['idarea', 'idreferencia'], 'exist', 'skipOnError' => true, 'targetClass' => CalendarioCalibracion::className(), 'targetAttribute' => ['idarea' => 'idarea', 'idreferencia' => 'idreferencia']],
            [['idcot'], 'exist', 'skipOnError' => true, 'targetClass' => Cotizaciones::className(), 'targetAttribute' => ['idcot' => 'idcot']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idcot' => 'No. Cotización',
            'idarea' => 'Idarea',
            'idreferencia' => 'Idreferencia',
            'costo' => 'Costo',
            'aceptado' => 'Aceptado',
            'descargar' => 'Descargar',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdarea0()
    {
        return $this->hasOne(CalendarioCalibracion::className(), ['idarea' => 'idarea', 'idreferencia' => 'idreferencia']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdcot0()
    {
        return $this->hasOne(Cotizaciones::className(), ['idcot' => 'idcot']);
    }

     /**
     * @return \yii\db\ActiveQuery
     */
    public function getSeguimiento0()
    {
        return $this->hasOne(SeguimientoCalibracion::className(), ['idcot' => 'idcot', 'idarea' => 'idarea', 'idreferencia' => 'idreferencia']);
    }
}