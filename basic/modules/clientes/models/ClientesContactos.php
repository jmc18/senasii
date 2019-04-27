<?php

namespace app\modules\clientes\models;
use app\modules\contactos\models\Contactos;

use Yii;

/**
 * This is the model class for table "clientes_contactos".
 *
 * @property integer $idcte
 * @property integer $nocontacto
 *
 * @property Contactos $nocontacto0
 * @property Clientes $idcte0
 */
class ClientesContactos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'clientes_contactos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idcte', 'nocontacto'], 'required'],
            [['idcte', 'nocontacto'], 'integer'],
            [['nocontacto'], 'exist', 'skipOnError' => true, 'targetClass' => Contactos::className(), 'targetAttribute' => ['nocontacto' => 'nocontacto']],
            [['idcte'], 'exist', 'skipOnError' => true, 'targetClass' => Clientes::className(), 'targetAttribute' => ['idcte' => 'idcte']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idcte' => 'Idcte',
            'nocontacto' => 'Nocontacto',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNocontacto0()
    {
        return $this->hasOne(Contactos::className(), ['nocontacto' => 'nocontacto']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdcte0()
    {
        return $this->hasOne(Clientes::className(), ['idcte' => 'idcte']);
    }
}