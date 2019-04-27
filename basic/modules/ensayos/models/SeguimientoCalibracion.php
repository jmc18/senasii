<?php

namespace app\modules\ensayos\models;
use Yii;
use app\modules\cotizaciones\models\CotizacionCalibracion;
/**
 * This is the model class for table "seguimiento_calibracion".
 *
 * @property string $idcot
 * @property integer $idarea
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
 * @property CotizacionCalibracion $idcot0
 */
class SeguimientoCalibracion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'seguimiento_calibracion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idcot', 'idarea', 'idreferencia'], 'required'],
            [['idarea', 'idreferencia'], 'integer'],
            [['fecha', 'termina_odec', 'valida_odec', 'termina_pago', 'valida_pago', 'termina_aceptacion', 'valida_aceptacion', 'termina_recepcion', 'valida_recepcion', 'termina_entrega', 'valida_entrega', 'termina_resultados', 'valida_resultados'], 'safe'],
            [['idcot'], 'string', 'max' => 15],
            [['credito'], 'string', 'max' => 1],
            [['codigo'], 'string', 'max' => 8],
            [['idcot', 'idarea', 'idreferencia'], 'exist', 'skipOnError' => true, 'targetClass' => CotizacionCalibracion::className(), 'targetAttribute' => ['idcot' => 'idcot', 'idarea' => 'idarea', 'idreferencia' => 'idreferencia']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idcot' => 'Idcot',
            'idarea' => 'Idarea',
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
            'termina_resultados' => 'Termina Resultados',
            'valida_resultados' => 'Valida Resultados',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdcot0()
    {
        return $this->hasOne(CotizacionCalibracion::className(), ['idcot' => 'idcot', 'idarea' => 'idarea', 'idreferencia' => 'idreferencia']);
    }
}