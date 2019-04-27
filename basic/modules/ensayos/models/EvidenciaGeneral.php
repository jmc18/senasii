<?php

namespace app\modules\ensayos\models;

use Yii;
use app\modules\catalogos\models\Etapas;

/**
 * This is the model class for table "evidencia_general".
 *
 * @property integer $idrama
 * @property integer $idsubrama
 * @property integer $idanalito
 * @property integer $idreferencia
 * @property integer $idcte
 * @property integer $nofiles
 * @property string $fecha
 * @property string $file
 * @property string $hash
 * @property string $validado
 * @property integer $idetapa
 *
 * @property CalendarioClientes $idrama0
 * @property Etapas $idetapa0
 */
class EvidenciaGeneral extends \yii\db\ActiveRecord
{
    public $image;
    public  $excel;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'evidencia_general';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['image'], 'safe'],
            [['excel'], 'safe'],
            [['image'], 'file', 'extensions'=>'jpg, gif, png, pdf'],
            [['excel'], 'file', 'extensions'=>'xls, xlsx'],

            [['idcot', 'idrama', 'idsubrama', 'idanalito', 'idreferencia', 'nofiles'], 'required'],
            [['idrama', 'idsubrama', 'idanalito', 'idreferencia', 'nofiles', 'idetapa'], 'integer'],
            [['fecha', 'validado'], 'safe'],
            [['idcot'], 'string', 'max' => 15],
            [['file', 'hash'], 'string', 'max' => 100],
            [['idcot', 'idrama', 'idsubrama', 'idanalito', 'idreferencia'], 'exist', 'skipOnError' => true, 'targetClass' => SeguimientoGeneral::className(), 'targetAttribute' => ['idcot' => 'idcot', 'idrama' => 'idrama', 'idsubrama' => 'idsubrama', 'idanalito' => 'idanalito', 'idreferencia' => 'idreferencia']],
            [['idetapa'], 'exist', 'skipOnError' => true, 'targetClass' => Etapas::className(), 'targetAttribute' => ['idetapa' => 'idetapa']],
         ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [

            'idcot' => 'Idcot',
            'idrama' => 'Idrama',
            'idsubrama' => 'Idsubrama',
            'idanalito' => 'Idanalito',
            'idreferencia' => 'Idreferencia',
            'nofiles' => 'Nofiles',
            'fecha' => 'Fecha',
            'file' => 'File',
            'hash' => 'Hash',
            'validado' => 'Validado',
            'idetapa' => 'Idetapa',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdcot0()
    {
        return $this->hasOne(SeguimientoGeneral::className(), ['idcot' => 'idcot', 'idrama' => 'idrama', 'idsubrama' => 'idsubrama', 'idanalito' => 'idanalito', 'idreferencia' => 'idreferencia']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdetapa0()
    {
        return $this->hasOne(Etapas::className(), ['idetapa' => 'idetapa']);
    }
}