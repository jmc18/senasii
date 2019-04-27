<?php

namespace app\modules\catalogos\models;

use Yii;

/**
 * This is the model class for table "etapas".
 *
 * @property integer $idetapa
 * @property string $tituloetapa
 * @property string $descetapa
 *
 * @property EvidenciaCalibracion[] $evidenciaCalibracions
 */
class Etapas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'etapas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tituloetapa'], 'string', 'max' => 50],
            [['descetapa'], 'string', 'max' => 150],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idetapa' => 'Idetapa',
            'tituloetapa' => 'Tituloetapa',
            'descetapa' => 'Descetapa',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvidenciaCalibracions()
    {
        return $this->hasMany(EvidenciaCalibracion::className(), ['idetapa' => 'idetapa']);
    }
}