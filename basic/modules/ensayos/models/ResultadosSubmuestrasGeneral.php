<?php

namespace app\modules\ensayos\models;

use Yii;

use app\modules\ensayos\models\UnidadesResultados;

/**
 * This is the model class for table "resultados_submuestras_general".
 *
 * @property integer $no_submuestra
 * @property string $idcot
 * @property integer $idrama
 * @property integer $idsubrama
 * @property integer $idanalito
 * @property integer $idreferencia
 * @property integer $idunidad
 * @property string $resultado
 * @property string $fehca_captura
 * @property string $fecha_validacion
 * @property string $parametro
 *
 * @property CotizacionGeneral $idcot0
 * @property UnidadesResultado $idunidad0
 */
class ResultadosSubmuestrasGeneral extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'resultados_submuestras_general';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_submuestra', 'idcot', 'idrama', 'idsubrama', 'idanalito', 'idreferencia'], 'required'],
            [['no_submuestra', 'idrama', 'idsubrama', 'idanalito', 'idreferencia', 'idunidad'], 'integer'],
            [['idcot'], 'string', 'max' => 15],
            [['parametro'], 'string', 'max' => 50],
            [['resultado'], 'string', 'max' => 50],
            [['idunidad'], 'exist', 'skipOnError' => true, 'targetClass' => UnidadesResultados::className(), 'targetAttribute' => ['idunidad' => 'idunidad']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'no_submuestra' => 'No Sub Muestra',
            'idcot' => 'Idcot',
            'idrama' => 'Idrama',
            'idsubrama' => 'Idsubrama',
            'idanalito' => 'Idanalito',
            'idreferencia' => 'Idreferencia',
            'idunidad' => 'Idunidad',
            'resultado' => 'Resultado',
            'fehca_captura' => 'fecha de Captura',
            'fecha_validacion' => 'fecha de Validación',
            'parametro' => 'Parametro',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdcot0()
    {
        return $this->hasOne(CotizacionGeneral::className(), ['idcot' => 'idcot', 'idrama' => 'idrama', 'idsubrama' => 'idsubrama', 'idanalito' => 'idanalito', 'idreferencia' => 'idreferencia']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdunidad0()
    {
        return $this->hasOne(UnidadesResultados::className(), ['idunidad' => 'idunidad']);
    }
}
