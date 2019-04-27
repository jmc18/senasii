<?php

namespace app\modules\ensayos\models;

use Yii;

use app\modules\ensayos\models\UnidadesResultados;

/**
 * This is the model class for table "resultados_submuestras_calibracion".
 *
 * @property integer $no_submuestra
 * @property string $idcot
 * @property integer $idarea
 * @property integer $idreferencia
 * @property integer $idunidad
 * @property string $resultado
 * @property string $fehca_captura
 * @property string $fecha_validacion
 * @property string $parametro
 *
 * @property CotizacionCalibracion $idcot0
 * @property UnidadesResultado $idunidad0
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
            [['no_submuestra', 'idcot', 'idarea', 'idreferencia'], 'required'],
            [['no_submuestra', 'idarea', 'idreferencia', 'idunidad'], 'integer'],
            [['fehca_captura', 'fecha_validacion'], 'safe'],
            [['idcot'], 'string', 'max' => 15],
            [['parametro'], 'string', 'max' => 15],
            [['resultado'], 'string', 'max' => 50],
            [['resultado'], 'required'],
            [['idunidad'], 'exist', 'skipOnError' => true, 'targetClass' => UnidadesResultados::className(), 'targetAttribute' => ['idunidad' => 'idunidad']],
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
            'idunidad' => 'Idunidad',
            'resultado' => 'Resultado',
            'fecha_captura' => 'Fehca Captura',
            'fecha_validacion' => 'Fecha Validacion',
            'parametro' => 'Parametro',
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
    public function getIdunidad0()
    {
        return $this->hasOne(UnidadesResultados::className(), ['idunidad' => 'idunidad']);
    }
}
