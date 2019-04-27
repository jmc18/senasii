<?php

namespace app\modules\catalogos\models;

use Yii;

/**
 * This is the model class for table "estatus".
 *
 * @property integer $idestatus
 * @property string $descestatus
 */
class Estatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'estatus';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['descestatus'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idestatus' => 'Idestatus',
            'descestatus' => 'Descestatus',
        ];
    }
}