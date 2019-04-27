<?php

namespace app\modules\calendarios\models;

use Yii;

/**
 * This is the model class for table "lineamientos_general".
 *
 * @property integer $idlineamiento
 * @property integer $idrama
 * @property integer $idsubrama
 * @property integer $idanalito
 * @property integer $idreferencia
 * @property string $file_linea
 * @property string $hash_linea
 * @property string $fecinilinea
 * @property string $fecfinlinea
 *
 * @property Calendario $idrama0
 */
class LineamientosGeneral extends \yii\db\ActiveRecord
{
    public $image;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lineamientos_general';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['image'], 'safe'],
            [['image'], 'file', 'extensions'=>'pdf'],

            [['idrama', 'idsubrama', 'idanalito', 'idreferencia'], 'integer'],
            [['fecinilinea', 'fecfinlinea'], 'safe'],
            [['file_linea', 'hash_linea'], 'string', 'max' => 100],
            [['idrama', 'idsubrama', 'idanalito', 'idreferencia'], 'exist', 'skipOnError' => true, 'targetClass' => Calendario::className(), 'targetAttribute' => ['idrama' => 'idrama', 'idsubrama' => 'idsubrama', 'idanalito' => 'idanalito', 'idreferencia' => 'idreferencia']],
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
            'idrama' => 'Idrama',
            'idsubrama' => 'Idsubrama',
            'idanalito' => 'Idanalito',
            'idreferencia' => 'Idreferencia',
            'file_linea' => 'File Linea',
            'hash_linea' => 'Hash Linea',
            'fecinilinea' => 'Fecinilinea',
            'fecfinlinea' => 'Fecfinlinea',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdrama0()
    {
        return $this->hasOne(Calendario::className(), ['idrama' => 'idrama', 'idsubrama' => 'idsubrama', 'idanalito' => 'idanalito', 'idreferencia' => 'idreferencia']);
    }
}