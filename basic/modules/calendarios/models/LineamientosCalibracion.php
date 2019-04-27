<?php

namespace app\modules\calendarios\models;

use Yii;

/**
 * This is the model class for table "lineamientos_calibracion".
 *
 * @property integer $idlineamiento
 * @property integer $idarea
 * @property integer $idreferencia
 * @property string $file_linea
 * @property string $hash_linea
 * @property string $fecinilinea
 * @property string $fecfinlinea
 *
 * @property CalendarioCalibracion $idarea0
 */
class LineamientosCalibracion extends \yii\db\ActiveRecord
{
    public $image;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lineamientos_calibracion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['image'], 'safe'],
            [['image'], 'file', 'extensions'=>'pdf'],

            [['idarea', 'idreferencia'], 'integer'],
            [['fecinilinea', 'fecfinlinea'], 'safe'],
            [['file_linea', 'hash_linea'], 'string', 'max' => 100],
            [['idarea', 'idreferencia'], 'exist', 'skipOnError' => true, 'targetClass' => CalendarioCalibracion::className(), 'targetAttribute' => ['idarea' => 'idarea', 'idreferencia' => 'idreferencia']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'image' => 'Archivo',
            'idlineamiento' => 'Idlineamiento',
            'idarea' => 'Idarea',
            'idreferencia' => 'Idreferencia',
            'file_linea' => 'File Linea',
            'hash_linea' => 'Hash Linea',
            'fecinilinea' => 'Fecha Inicial',
            'fecfinlinea' => 'Fecha Final',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdarea0()
    {
        return $this->hasOne(CalendarioCalibracion::className(), ['idarea' => 'idarea', 'idreferencia' => 'idreferencia']);
    }
}