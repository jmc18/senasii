<?php

namespace app\modules\calendarios\models;

use Yii;
use app\modules\catalogos\models\Analitos;
use app\modules\catalogos\models\Ramas;
use app\modules\catalogos\models\Referencias;
use app\modules\catalogos\models\Subramas;
use app\modules\catalogos\models\Estatus;

/**
 * This is the model class for table "calendario".
 *
 * @property integer $idrama
 * @property integer $idsubrama
 * @property integer $idanalito
 * @property integer $idreferencia
 * @property string $periodoini
 * @property string $periodofin
 * @property double $costo
 * @property string $fechaentrega
 * @property string $fecharesultados
 * @property string $fechafinal
 * @property string $intervalo
 *
 * @property Analitos $idanalito0
 * @property Ramas $idrama0
 * @property Referencias $idreferencia0
 * @property Subramas $idsubrama0
 */
class Calendario extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'calendario';
    }

    /**
     * @inheritdoc
     */
     public function rules()
    {
        return [
        
            [['idrama', 'idsubrama', 'idanalito', 'idreferencia'], 'required'],
            [['idrama', 'idsubrama', 'idanalito', 'idreferencia', 'idestatus'], 'integer'],
            [['periodoini', 'periodofin', 'fechaentrega', 'fecharesultados', 'fechafinal'], 'safe'],
            [['costo'], 'number'],
            [['intervalo'], 'string', 'max' => 50],
            [['idanalito'], 'exist', 'skipOnError' => true, 'targetClass' => Analitos::className(), 'targetAttribute' => ['idanalito' => 'idanalito']],
            [['idrama'], 'exist', 'skipOnError' => true, 'targetClass' => Ramas::className(), 'targetAttribute' => ['idrama' => 'idrama']],
            [['idreferencia'], 'exist', 'skipOnError' => true, 'targetClass' => Referencias::className(), 'targetAttribute' => ['idreferencia' => 'idreferencia']],
            [['idestatus'], 'exist', 'skipOnError' => true, 'targetClass' => Estatus::className(), 'targetAttribute' => ['idestatus' => 'idestatus']],
            [['idsubrama'], 'exist', 'skipOnError' => true, 'targetClass' => Subramas::className(), 'targetAttribute' => ['idsubrama' => 'idsubrama']],
       ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idrama' => 'Rama',
            'idsubrama' => 'Subrama',
            'idanalito' => 'Analito',
            'idreferencia' => 'Referencia',
            'periodoini' => 'Inicio Ensayo',
            'periodofin' => 'Fin Ensayo',
            'costo' => 'Costo',
            'fechaentrega' => 'Entrega',
            'fecharesultados' => 'Resultados',
            'fechafinal' => 'Fechafinal',
            'intervalo' => 'Intervalo',
            'idestatus' => 'Estatus',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdanalito0()
    {
        return $this->hasOne(Analitos::className(), ['idanalito' => 'idanalito']);
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
    public function getIdsubrama0()
    {
        return $this->hasOne(Subramas::className(), ['idsubrama' => 'idsubrama']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalendarioClientes()
    {
        return $this->hasMany(CalendarioClientes::className(), ['idrama' => 'idrama', 'idsubrama' => 'idsubrama', 'idanalito' => 'idanalito', 'idreferencia' => 'idreferencia']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdctes()
    {
        return $this->hasMany(Clientes::className(), ['idcte' => 'idcte'])->viaTable('calendario_clientes', ['idrama' => 'idrama', 'idsubrama' => 'idsubrama', 'idanalito' => 'idanalito', 'idreferencia' => 'idreferencia']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCotizacionGenerals()
    {
        return $this->hasMany(CotizacionGeneral::className(), ['idrama' => 'idrama', 'idsubrama' => 'idsubrama', 'idanalito' => 'idanalito', 'idreferencia' => 'idreferencia']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdcots()
    {
        return $this->hasMany(Cotizaciones::className(), ['idcot' => 'idcot'])->viaTable('cotizacion_general', ['idrama' => 'idrama', 'idsubrama' => 'idsubrama', 'idanalito' => 'idanalito', 'idreferencia' => 'idreferencia']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLineamientosGenerals()
    {
        return $this->hasMany(LineamientosGeneral::className(), ['idrama' => 'idrama', 'idsubrama' => 'idsubrama', 'idanalito' => 'idanalito', 'idreferencia' => 'idreferencia']);
    }
}
