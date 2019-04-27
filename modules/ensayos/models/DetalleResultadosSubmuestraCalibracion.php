<?php

namespace app\modules\ensayos\models;

use Yii;

/**
 * This is the model class for table "detalle_resultados_submuestra_calibracion".
 *
 * @property integer $no_submuestra
 * @property string $idcot
 * @property integer $idarea
 * @property integer $idreferencia
 * @property integer $idseccion
 * @property integer $id_campo
 * @property string $valor
 *
 * @property ResultadosSubmuestrasCalibracion $noSubmuestra
 * @property DetalleFormularioSeccion $idseccion0
 */
class DetalleResultadosSubmuestraCalibracion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'detalle_resultados_submuestra_calibracion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_submuestra', 'idcot', 'idarea', 'idreferencia', 'idseccion', 'id_campo'], 'required'],
            [['no_submuestra', 'idarea', 'idreferencia', 'idseccion', 'id_campo'], 'integer'],
            [['idcot'], 'string', 'max' => 15],
            [['valor'], 'string', 'max' => 100],
            [['no_submuestra', 'idcot', 'idarea', 'idreferencia'], 'exist', 'skipOnError' => true, 'targetClass' => ResultadosSubmuestrasCalibracion::className(), 'targetAttribute' => ['no_submuestra' => 'no_submuestra', 'idcot' => 'idcot', 'idarea' => 'idarea', 'idreferencia' => 'idreferencia']],
            [['idseccion', 'id_campo'], 'exist', 'skipOnError' => true, 'targetClass' => DetalleFormularioSeccion::className(), 'targetAttribute' => ['idseccion' => 'idseccion', 'id_campo' => 'id_campo']],
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
            'idseccion' => 'Idseccion',
            'id_campo' => 'Id Campo',
            'valor' => 'Valor',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNoSubmuestra()
    {
        return $this->hasOne(ResultadosSubmuestrasCalibracion::className(), ['no_submuestra' => 'no_submuestra', 'idcot' => 'idcot', 'idarea' => 'idarea', 'idreferencia' => 'idreferencia']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdseccion0()
    {
        return $this->hasOne(DetalleFormularioSeccion::className(), ['idseccion' => 'idseccion', 'id_campo' => 'id_campo']);
    }
}
