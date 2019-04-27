<?php

namespace app\modules\catalogos\models;

use Yii;

/**
 * This is the model class for table "referencias".
 *
 * @property integer $idreferencia
 * @property string $descreferencia
 *
 * @property CalendarioCalibracion[] $calendarioCalibracions
 * @property Areas[] $idareas
 */
class Referencias extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'referencias';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['descreferencia'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idreferencia' => 'Idreferencia',
            'descreferencia' => 'Descripción',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalendarioCalibracions()
    {
        return $this->hasMany(CalendarioCalibracion::className(), ['idreferencia' => 'idreferencia']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdareas()
    {
        return $this->hasMany(Areas::className(), ['idarea' => 'idarea'])->viaTable('calendario_calibracion', ['idreferencia' => 'idreferencia']);
    }
}
