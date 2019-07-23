<?php

namespace app\modules\ensayos\models;

use Yii;

/**
 * This is the model class for table "resultados_submuestras_calibracion".
 *
 * @property integer $no_submuestra
 * @property string $idcot
 * @property integer $idarea
 * @property integer $idreferencia
 * @property string $fehca_captura
 * @property string $fecha_validacion
 *
 * @property CotizacionCalibracion $idcot0
 */
class ResultadosSubmuestrasCalibracion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'resultados_submuestras_calibracion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_submuestra', 'idcot', 'idreferencia'], 'required'],
            [['no_submuestra', 'idreferencia'], 'integer'],
            [['fehca_captura', 'fecha_validacion'], 'safe'],
            [['idcot'], 'string', 'max' => 15],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'no_submuestra' => 'No Submuestra',
            'idcot' => 'Idcot',
            'idarea' => 'Idarea',
            'idreferencia' => 'Idreferencia',
            'fecha_captura' => 'Fehca Captura',
            'fecha_validacion' => 'Fecha Validacion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdcot0()
    {
        return $this->hasOne(CotizacionCalibracion::className(), ['idcot' => 'idcot', 'idarea' => 'idarea', 'idreferencia' => 'idreferencia']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
}
