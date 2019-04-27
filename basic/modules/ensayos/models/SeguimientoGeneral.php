<?php

namespace app\modules\ensayos\models;

use Yii;
use app\modules\calendarios\models\Calendario;
use app\modules\cotizaciones\models\CotizacionGeneral;

/**
 * This is the model class for table "seguimiento_general".
 *
 * @property string $idcot
 * @property integer $idrama
 * @property integer $idsubrama
 * @property integer $idanalito
 * @property integer $idreferencia
 * @property string $fecha
 * @property string $termina_odec
 * @property string $valida_odec
 * @property string $termina_pago
 * @property string $valida_pago
 * @property string $credito
 * @property string $termina_aceptacion
 * @property string $valida_aceptacion
 * @property string $codigo
 * @property string $termina_recepcion
 * @property string $valida_recepcion
 * @property string $termina_entrega
 * @property string $valida_entrega
 * @property string $termina_resultados
 * @property string $valida_resultados
 *
 * @property CotizacionGeneral $idcot0
 */
class SeguimientoGeneral extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'seguimiento_general';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idcot', 'idrama', 'idsubrama', 'idanalito', 'idreferencia'], 'required'],
            [['idrama', 'idsubrama', 'idanalito', 'idreferencia'], 'integer'],
            [['fecha', 'valida_odec', 'valida_pago', 'valida_aceptacion', 'valida_recepcion', 'valida_entrega', 'termina_resultados', 'valida_resultados'], 'safe'],
            [['idcot'], 'string', 'max' => 15],
            [['termina_odec', 'termina_pago', 'termina_aceptacion', 'termina_recepcion', 'termina_entrega'], 'string', 'max' => 100],
            [['credito'], 'string', 'max' => 1],
            [['codigo'], 'string', 'max' => 8],
            [['idcot', 'idrama', 'idsubrama', 'idanalito', 'idreferencia'], 'exist', 'skipOnError' => true, 'targetClass' => CotizacionGeneral::className(), 'targetAttribute' => ['idcot' => 'idcot', 'idrama' => 'idrama', 'idsubrama' => 'idsubrama', 'idanalito' => 'idanalito', 'idreferencia' => 'idreferencia']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idcot' => 'Idcot',
            'idrama' => 'Idrama',
            'idsubrama' => 'Idsubrama',
            'idanalito' => 'Idanalito',
            'idreferencia' => 'Idreferencia',
            'fecha' => 'Fecha',
            'termina_odec' => 'Termina Odec',
            'valida_odec' => 'Valida Odec',
            'termina_pago' => 'Termina Pago',
            'valida_pago' => 'Valida Pago',
            'credito' => 'Credito',
            'termina_aceptacion' => 'Termina Aceptacion',
            'valida_aceptacion' => 'Valida Aceptacion',
            'codigo' => 'Codigo',
            'termina_recepcion' => 'Termina Recepcion',
            'valida_recepcion' => 'Valida Recepcion',
            'termina_entrega' => 'Termina Entrega',
            'valida_entrega' => 'Valida Entrega',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdcot0()
    {
        return $this->hasOne(CotizacionGeneral::className(), ['idcot' => 'idcot', 'idrama' => 'idrama', 'idsubrama' => 'idsubrama', 'idanalito' => 'idanalito', 'idreferencia' => 'idreferencia']);
    }
}