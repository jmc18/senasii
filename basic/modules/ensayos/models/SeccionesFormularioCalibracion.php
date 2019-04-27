<?php

namespace app\modules\ensayos\models;

use Yii;
use app\modules\catalogos\models\Areas;

/**
 * This is the model class for table "secciones_formulario_calibracion".
 *
 * @property integer $idseccion
 * @property integer $idarea
 * @property string $nombre
 * @property integer $orden
 * @property integer $status
 *
 * @property DetalleFormularioSeccion[] $detalleFormularioSeccions
 * @property CamposFormulariosCalibracion[] $idCampos
 * @property Areas $idarea0
 */
class SeccionesFormularioCalibracion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'secciones_formulario_calibracion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idarea', 'orden', 'status'], 'integer'],
            [['nombre'], 'string', 'max' => 80],
            [['idarea'], 'exist', 'skipOnError' => true, 'targetClass' => Areas::className(), 'targetAttribute' => ['idarea' => 'idarea']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idseccion' => 'Idseccion',
            'idarea' => 'Idarea',
            'nombre' => 'Nombre',
            'orden' => 'Orden',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetalleFormularioSeccions()
    {
        return $this->hasMany(DetalleFormularioSeccion::className(), ['idseccion' => 'idseccion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCampos()
    {
        return $this->hasMany(CamposFormulariosCalibracion::className(), ['id_campo' => 'id_campo'])->viaTable('detalle_formulario_seccion', ['idseccion' => 'idseccion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdarea0()
    {
        return $this->hasOne(Areas::className(), ['idarea' => 'idarea']);
    }
}
