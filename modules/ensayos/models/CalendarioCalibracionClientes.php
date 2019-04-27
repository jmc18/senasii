<?php

namespace app\modules\ensayos\models;

use Yii;
use app\modules\calendarios\models\CalendarioCalibracion;
use app\modules\clientes\models\Clientes;

/**
 * This is the model class for table "calendario_calibracion_clientes".
 *
 * @property integer $idarea
 * @property integer $idreferencia
 * @property integer $idcte
 * @property string $fecha
 *
 * @property CalendarioCalibracion $idarea0
 * @property Clientes $idcte0
 */
class CalendarioCalibracionClientes extends \yii\db\ActiveRecord
{
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'calendario_calibracion_clientes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idarea', 'idreferencia', 'idcte'], 'required'],
            [['idarea', 'idreferencia', 'idcte'], 'integer'],
            [['fecha', 'termina_odec', 'valida_odec', 'termina_pago', 'valida_pago', 'termina_aceptacion', 'valida_aceptacion', 'termina_recepcion', 'valida_recepcion', 'termina_entrega', 'valida_entrega'], 'safe'],
            [['codigo'], 'string', 'max' => 8],
            [['credito'], 'string', 'max' => 1],
            [['idarea', 'idreferencia'], 'exist', 'skipOnError' => true, 'targetClass' => CalendarioCalibracion::className(), 'targetAttribute' => ['idarea' => 'idarea', 'idreferencia' => 'idreferencia']],
            [['idcte'], 'exist', 'skipOnError' => true, 'targetClass' => Clientes::className(), 'targetAttribute' => ['idcte' => 'idcte']],
       ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idarea' => 'Idarea',
            'idreferencia' => 'Idreferencia',
            'idcte' => 'Idcte',
            'fecha' => 'Fecha',
            'termina_odec' => 'Termina Odec',
            'valida_odec' => 'Valida Odec',
            'termina_pago' => 'Termina Pago',
            'valida_pago' => 'Valida Pago',
            'termina_aceptacion' => 'Termina Aceptacion',
            'valida_aceptacion' => 'Valida Aceptacion',
            'codigo' => 'Codigo',
            'termina_recepcion' => 'Termina Recepcion',
            'valida_recepcion' => 'Valida Recepcion',
            'termina_entrega' => 'Termina Entrega',
            'valida_entrega' => 'Valida Entrega',
            'credito' => 'Crédito',
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
    public function getIdcte0()
    {
        return $this->hasOne(Clientes::className(), ['idcte' => 'idcte']);
    }

     /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvidenciaCalibracion()
    {
        return $this->hasOne(EvidenciaCalibracion::className(), ['idarea' => 'idarea', 'idreferencia' => 'idreferencia', 'idcte' => 'idcte']);
    }
}