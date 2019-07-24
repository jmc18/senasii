<?php

namespace app\modules\alertas\models;

use Yii;

/**
 * This is the model class for table "cotizaciones".
 *
 * @property string $idcot
 * @property integer $idcte
 * @property integer $nocontacto
 * @property string $fecha
 * @property string $fechaexpira
 * @property integer $anio
 * @property integer $mes
 * @property integer $nocot
 *
 * @property CotizacionCalibracion[] $cotizacionCalibracions
 * @property CalendarioCalibracion[] $idareas
 * @property CotizacionGeneral[] $cotizacionGenerals
 * @property Calendario[] $idramas
 * @property Clientes $idcte0
 * @property ClientesContactos $nocontacto0
 */
class Cotizaciones extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cotizaciones';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idcot', 'fechaexpira'], 'required'],
            [['idcte', 'nocontacto', 'anio', 'mes', 'nocot'], 'integer'],
            [['fecha', 'fechaexpira'], 'safe'],
            [['idcot'], 'string', 'max' => 15],
            [['idcte'], 'exist', 'skipOnError' => true, 'targetClass' => Clientes::className(), 'targetAttribute' => ['idcte' => 'idcte']],
            [['nocontacto'], 'exist', 'skipOnError' => true, 'targetClass' => ClientesContactos::className(), 'targetAttribute' => ['nocontacto' => 'nocontacto']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idcot' => 'Idcot',
            'idcte' => 'Idcte',
            'nocontacto' => 'Nocontacto',
            'fecha' => 'Fecha',
            'fechaexpira' => 'Fechaexpira',
            'anio' => 'Anio',
            'mes' => 'Mes',
            'nocot' => 'Nocot',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCotizacionCalibracions()
    {
        return $this->hasMany(CotizacionCalibracion::className(), ['idcot' => 'idcot']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdareas()
    {
        return $this->hasMany(CalendarioCalibracion::className(), ['idarea' => 'idarea', 'idreferencia' => 'idreferencia'])->viaTable('cotizacion_calibracion', ['idcot' => 'idcot']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCotizacionGenerals()
    {
        return $this->hasMany(CotizacionGeneral::className(), ['idcot' => 'idcot']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdramas()
    {
        return $this->hasMany(Calendario::className(), ['idrama' => 'idrama', 'idsubrama' => 'idsubrama', 'idanalito' => 'idanalito', 'idreferencia' => 'idreferencia'])->viaTable('cotizacion_general', ['idcot' => 'idcot']);
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
    public function getNocontacto0()
    {
        return $this->hasOne(ClientesContactos::className(), ['nocontacto' => 'nocontacto']);
    }
}
