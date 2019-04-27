<?php

namespace app\modules\ensayos\models;

use Yii;

/**
 * This is the model class for table "detalle_formulario_seccion".
 *
 * @property integer $idseccion
 * @property integer $id_campo
 * @property integer $idunidad
 * @property string $formula
 * @property string $texto_etiquetas
 * @property string $tipo_entrada
 * @property string $requerido
 * @property integer $orden
 * @property integer $status
 * @property string $fecha_ingreso
 *
 * @property CamposFormulariosCalibracion $idCampo
 * @property UnidadesResultado $idunidad0
 * @property SeccionesFormularioCalibracion $idseccion0
 * @property DetalleResultadosSubmuestraCalibracion[] $detalleResultadosSubmuestraCalibracions
 * @property ResultadosSubmuestrasCalibracion[] $noSubmuestras
 */
class DetalleFormularioSeccion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'detalle_formulario_seccion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idseccion', 'id_campo', 'tipo_entrada', 'requerido', 'orden'], 'required'],
            [['idseccion', 'id_campo', 'idunidad', 'orden', 'status'], 'integer'],
            [['fecha_ingreso'], 'safe'],
            [['formula', 'texto_etiquetas'], 'string', 'max' => 100],
            [['tipo_entrada'], 'string', 'max' => 30],
            [['requerido'], 'string', 'max' => 2],
            [['id_campo'], 'exist', 'skipOnError' => true, 'targetClass' => CamposFormulariosCalibracion::className(), 'targetAttribute' => ['id_campo' => 'id_campo']],
            [['idunidad'], 'exist', 'skipOnError' => true, 'targetClass' => UnidadesResultado::className(), 'targetAttribute' => ['idunidad' => 'idunidad']],
            [['idseccion'], 'exist', 'skipOnError' => true, 'targetClass' => SeccionesFormularioCalibracion::className(), 'targetAttribute' => ['idseccion' => 'idseccion']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idseccion' => 'Idseccion',
            'id_campo' => 'Id Campo',
            'idunidad' => 'Idunidad',
            'formula' => 'Formula',
            'texto_etiquetas' => 'Texto Etiquetas',
            'tipo_entrada' => 'Tipo Entrada',
            'requerido' => 'Requerido',
            'orden' => 'Orden',
            'status' => 'Status',
            'fecha_ingreso' => 'Fecha Ingreso',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCampo()
    {
        return $this->hasOne(CamposFormulariosCalibracion::className(), ['id_campo' => 'id_campo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdunidad0()
    {
        return $this->hasOne(UnidadesResultado::className(), ['idunidad' => 'idunidad']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdseccion0()
    {
        return $this->hasOne(SeccionesFormularioCalibracion::className(), ['idseccion' => 'idseccion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetalleResultadosSubmuestraCalibracions()
    {
        return $this->hasMany(DetalleResultadosSubmuestraCalibracion::className(), ['idseccion' => 'idseccion', 'id_campo' => 'id_campo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNoSubmuestras()
    {
        return $this->hasMany(ResultadosSubmuestrasCalibracion::className(), ['no_submuestra' => 'no_submuestra', 'idcot' => 'idcot', 'idarea' => 'idarea', 'idreferencia' => 'idreferencia'])->viaTable('detalle_resultados_submuestra_calibracion', ['idseccion' => 'idseccion', 'id_campo' => 'id_campo']);
    }
}
