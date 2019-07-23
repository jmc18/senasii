<?php

namespace app\modules\catalogos\models\areas;

use Yii;

/**
 * This is the model class for table "campos_formularios_calibracion".
 *
 * @property integer $id_campo
 * @property string $concepto
 * @property integer $status
 *
 * @property DetalleFormularioSeccion[] $detalleFormularioSeccions
 * @property SeccionesFormularioCalibracion[] $idseccions
 */
class CamposFormulariosCalibracion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'campos_formularios_calibracion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['concepto'], 'required'],
            [['status'], 'integer'],
            [['concepto'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_campo' => 'Id Campo',
            'concepto' => 'Concepto',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetalleFormularioSeccions()
    {
        return $this->hasMany(DetalleFormularioSeccion::className(), ['id_campo' => 'id_campo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdseccions()
    {
        return $this->hasMany(SeccionesFormularioCalibracion::className(), ['idseccion' => 'idseccion'])->viaTable('detalle_formulario_seccion', ['id_campo' => 'id_campo']);
    }
}
