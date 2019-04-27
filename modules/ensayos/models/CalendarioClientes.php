<?php

namespace app\modules\ensayos\models;

use Yii;
use app\modules\calendarios\models\Calendario;
use app\modules\clientes\models\Clientes;

/**
 * This is the model class for table "calendario_clientes".
 *
 * @property integer $idrama
 * @property integer $idsubrama
 * @property integer $idanalito
 * @property integer $idreferencia
 * @property integer $idcte
 *
 * @property Calendario $idrama0
 * @property Clientes $idcte0
 */
class CalendarioClientes extends \yii\db\ActiveRecord
{
    public $image;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'calendario_clientes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
       return [
            [['idrama', 'idsubrama', 'idanalito', 'idreferencia', 'idcte'], 'required'],
            [['idrama', 'idsubrama', 'idanalito', 'idreferencia', 'idcte'], 'integer'],
            [['fecha', 'valida_odec', 'valida_pago', 'valida_aceptacion', 'valida_recepcion', 'valida_entrega'], 'safe'],
            [['termina_odec', 'termina_pago', 'termina_aceptacion', 'termina_recepcion', 'termina_entrega'], 'string', 'max' => 100],
            [['codigo'], 'string', 'max' => 8],
            [['credito'], 'string', 'max' => 1],
            [['idrama', 'idsubrama', 'idanalito', 'idreferencia'], 'exist', 'skipOnError' => true, 'targetClass' => Calendario::className(), 'targetAttribute' => ['idrama' => 'idrama', 'idsubrama' => 'idsubrama', 'idanalito' => 'idanalito', 'idreferencia' => 'idreferencia']],
            [['idcte'], 'exist', 'skipOnError' => true, 'targetClass' => Clientes::className(), 'targetAttribute' => ['idcte' => 'idcte']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idrama' => 'Idrama',
            'idsubrama' => 'Idsubrama',
            'idanalito' => 'Idanalito',
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
    public function getIdrama0()
    {
        return $this->hasOne(Calendario::className(), ['idrama' => 'idrama', 'idsubrama' => 'idsubrama', 'idanalito' => 'idanalito', 'idreferencia' => 'idreferencia']);
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
    public function getEvidenciaGenerals()
    {
        return $this->hasMany(EvidenciaGeneral::className(), ['idrama' => 'idrama', 'idsubrama' => 'idsubrama', 'idanalito' => 'idanalito', 'idreferencia' => 'idreferencia', 'idcte' => 'idcte']);
    }
}