<?php

namespace app\modules\cotizaciones\models;

use Yii;
use app\modules\calendarios\models\Calendario;
use app\modules\ensayos\models\SeguimientoGeneral;

/**
 * This is the model class for table "cotizacion_general".
 *
 * @property integer $idcot
 * @property integer $idrama
 * @property integer $idsubrama
 * @property integer $idanalito
 * @property integer $idreferencia
 * @property double $costo
 *
 * @property Calendario $idrama0
 * @property Cotizaciones $idcot0
 */
class CotizacionGeneral extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cotizacion_general';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idcot', 'idrama', 'idsubrama', 'idanalito', 'idreferencia'], 'required'],
            [['idrama', 'idsubrama', 'idanalito', 'idreferencia', 'descargar'], 'integer'],
            [['costo'], 'number'],
            [['aceptado'], 'safe'],
            [['idcot'], 'string', 'max' => 15],
            [['idrama', 'idsubrama', 'idanalito', 'idreferencia'], 'exist', 'skipOnError' => true, 'targetClass' => Calendario::className(), 'targetAttribute' => ['idrama' => 'idrama', 'idsubrama' => 'idsubrama', 'idanalito' => 'idanalito', 'idreferencia' => 'idreferencia']],
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
            'idrama' => 'Idrama',
            'idsubrama' => 'Idsubrama',
            'idanalito' => 'Idanalito',
            'idreferencia' => 'Idreferencia',
            'costo' => 'Costo',
            'aceptado' => 'Aceptado',
            'descargar' => 'Descargar',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdrama0()
    {
        return $this->hasOne(Calendario::className(), ['idrama' => 'idrama', 'idsubrama' => 'idsubrama', 'idanalito' => 'idanalito', 'idreferencia' => 'idreferencia']);
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
        return $this->hasOne(SeguimientoGeneral::className(), ['idcot' => 'idcot', 'idrama' => 'idrama', 'idsubrama' => 'idsubrama', 'idanalito' => 'idanalito', 'idreferencia' => 'idreferencia']);
    }
}