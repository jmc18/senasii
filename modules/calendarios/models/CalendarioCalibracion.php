<?php

namespace app\modules\calendarios\models;


use Yii;
use app\modules\catalogos\models\Estatus;
use app\modules\catalogos\models\Areas;
use app\modules\catalogos\models\Referencias;

/**
 * This is the model class for table "calendario_calibracion".
 *
 * @property integer $idarea
 * @property integer $idreferencia
 * @property string $intervalo
 * @property string $periodoini
 * @property string $peridodfin
 * @property string $fecinicio
 *
 * @property Areas $idarea0
 * @property Referencias $idreferencia0
 */
class CalendarioCalibracion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'calendario_calibracion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idarea', 'idreferencia'], 'required'],
            [['idarea', 'idreferencia', 'idestatus'], 'integer'],
            [['periodoini', 'peridodfin', 'fecinicio'], 'safe'],
            [['costo'], 'number'],
            [['intervalo'], 'string', 'max' => 50],
            [['idarea'], 'exist', 'skipOnError' => true, 'targetClass' => Areas::className(), 'targetAttribute' => ['idarea' => 'idarea']],
            [['idreferencia'], 'exist', 'skipOnError' => true, 'targetClass' => Referencias::className(), 'targetAttribute' => ['idreferencia' => 'idreferencia']],
            [['idestatus'], 'exist', 'skipOnError' => true, 'targetClass' => Estatus::className(), 'targetAttribute' => ['idestatus' => 'idestatus']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idarea' => 'Area',
            'idreferencia' => 'Referencia',
            'intervalo' => 'Intervalo',
            'periodoini' => 'Inicio Periodo',
            'peridodfin' => 'Fin Perido',
            'fecinicio' => 'Fecha Inicio',
            'idestatus' => 'Estatus',
            'costo' => 'Costo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdarea0()
    {
        return $this->hasOne(Areas::className(), ['idarea' => 'idarea']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdreferencia0()
    {
        return $this->hasOne(Referencias::className(), ['idreferencia' => 'idreferencia']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdestatus0()
    {
        return $this->hasOne(Estatus::className(), ['idestatus' => 'idestatus']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCotizacionCalibracions()
    {
        return $this->hasMany(CotizacionCalibracion::className(), ['idarea' => 'idarea', 'idreferencia' => 'idreferencia']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdcots()
    {
        return $this->hasMany(Cotizaciones::className(), ['idcot' => 'idcot'])->viaTable('cotizacion_calibracion', ['idarea' => 'idarea', 'idreferencia' => 'idreferencia']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLineamientosCalibracions()
    {
        return $this->hasMany(LineamientosCalibracion::className(), ['idarea' => 'idarea', 'idreferencia' => 'idreferencia']);
    }
}
