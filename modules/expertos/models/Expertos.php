<?php

namespace app\modules\expertos\models;

use Yii;

/**
 * This is the model class for table "expertos".
 *
 * @property integer $idexperto
 * @property string $nomexperto
 * @property string $apepat
 * @property string $apemat
 * @property string $email
 * @property string $telexperto
 * @property string $nacionalidad
 */
class Expertos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'expertos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nomexperto', 'email'], 'string', 'max' => 50],
            [['apepat', 'apemat', 'nacionalidad'], 'string', 'max' => 30],
            [['telexperto'], 'string', 'max' => 10],
            [['email'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idexperto' => 'Idexperto',
            'nomexperto' => 'Nomexperto',
            'apepat' => 'Apepat',
            'apemat' => 'Apemat',
            'email' => 'Email',
            'telexperto' => 'Telexperto',
            'nacionalidad' => 'Nacionalidad',
        ];
    }
}
