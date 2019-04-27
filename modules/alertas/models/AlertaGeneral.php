<?php

namespace app\modules\alertas\models;

use Yii;
use app\modules\ensayos\models\SeguimientoGeneral; 

/**
 * This is the model class for table "alerta_general".
 *
 * @property integer $idalerta
 * @property integer $idrama
 * @property integer $idsubrama
 * @property integer $idanalito
 * @property integer $idreferencia
 * @property integer $idcte
 * @property string $fecha
 * @property string $msjalerta
 * @property string $estatus
 *
 * @property CalendarioClientes $idrama0
 */
class AlertaGeneral extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'alerta_general';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idrama', 'idsubrama', 'idanalito', 'idreferencia'], 'integer'],
            [['fecha'], 'safe'],
            [['msjalerta'], 'string'],
            [['idcot'], 'string', 'max' => 15],
            [['estatus'], 'string', 'max' => 1],
            [['idcot', 'idrama', 'idsubrama', 'idanalito', 'idreferencia'], 'exist', 'skipOnError' => true, 'targetClass' => SeguimientoGeneral::className(), 'targetAttribute' => ['idcot' => 'idcot', 'idrama' => 'idrama', 'idsubrama' => 'idsubrama', 'idanalito' => 'idanalito', 'idreferencia' => 'idreferencia']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idalerta' => 'Idalerta',
            'idcot' => 'Idcot',
            'idrama' => 'Idrama',
            'idsubrama' => 'Idsubrama',
            'idanalito' => 'Idanalito',
            'idreferencia' => 'Idreferencia',
            'fecha' => 'Fecha',
            'msjalerta' => 'Msjalerta',
            'estatus' => 'Estatus',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdcot0()
    {
        return $this->hasOne(SeguimientoGeneral::className(), ['idcot' => 'idcot', 'idrama' => 'idrama', 'idsubrama' => 'idsubrama', 'idanalito' => 'idanalito', 'idreferencia' => 'idreferencia']);
    }
}