<?php

namespace app\modules\ensayos\models;

use Yii;

/**
 * This is the model class for table "unidades_resultado".
 *
 * @property integer $idunidad
 * @property string $nombre
 * @property string $abre
 *
 * @property ResultadosSubmuestrasCalibracion[] $resultadosSubmuestrasCalibracions
 * @property ResultadosSubmuestrasGeneral[] $resultadosSubmuestrasGenerals
 */
class UnidadesResultados extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'unidades_resultado';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre'], 'string', 'max' => 50],
            [['abre'], 'string', 'max' => 12],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idunidad' => 'Idunidad',
            'nombre' => 'Nombre',
            'abre' => 'Abre',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResultadosSubmuestrasCalibracions()
    {
        return $this->hasMany(ResultadosSubmuestrasCalibracion::className(), ['idunidad' => 'idunidad']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResultadosSubmuestrasGenerals()
    {
        return $this->hasMany(ResultadosSubmuestrasGeneral::className(), ['idunidad' => 'idunidad']);
    }
}
