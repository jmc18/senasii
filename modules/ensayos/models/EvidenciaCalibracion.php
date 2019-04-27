<?php

namespace app\modules\ensayos\models;

use Yii;
use app\modules\catalogos\models\Etapas;

/**
 * This is the model class for table "evidencia_calibracion".
 *
 * @property integer $idarea
 * @property integer $idreferencia
 * @property integer $idcte
 * @property string $file
 * @property string $hash
 * @property string $validado
 * @property integer $idetapa
 *
 * @property CalendarioCalibracionClientes $idarea0
 * @property Etapas $idetapa0
 */
class EvidenciaCalibracion extends \yii\db\ActiveRecord
{
    public $image;
    public  $excel;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'evidencia_calibracion';
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

            [['idcot', 'idarea', 'idreferencia', 'nofiles'], 'required'],
            [['idarea', 'idreferencia', 'nofiles', 'idetapa'], 'integer'],
            [['fecha', 'validado'], 'safe'],
            [['idcot'], 'string', 'max' => 15],
            [['file', 'hash'], 'string', 'max' => 100],
            [['idcot', 'idarea', 'idreferencia'], 'exist', 'skipOnError' => true, 'targetClass' => SeguimientoCalibracion::className(), 'targetAttribute' => ['idcot' => 'idcot', 'idarea' => 'idarea', 'idreferencia' => 'idreferencia']],
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
            'idarea' => 'Idarea',
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
        return $this->hasOne(SeguimientoCalibracion::className(), ['idcot' => 'idcot', 'idarea' => 'idarea', 'idreferencia' => 'idreferencia']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdetapa0()
    {
        return $this->hasOne(Etapas::className(), ['idetapa' => 'idetapa']);
    }
}