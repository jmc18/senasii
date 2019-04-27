<?php

namespace app\modules\contactos\models;

use Yii;

/**
 * This is the model class for table "contactos".
 *
 * @property integer $nocontacto
 * @property string $nombrecon
 * @property string $apepatcon
 * @property string $apematcon
 * @property string $emailcon
 * @property string $telcon
 *
 * @property ClientesContactos[] $clientesContactos
 * @property Clientes[] $idctes
 */
class Contactos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'contactos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombrecon', 'apepatcon', 'apematcon', 'emailcon'], 'string', 'max' => 50],
            [['telcon'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'nocontacto' => 'Nocontacto',
            'nombrecon' => 'Nombre Contacto',
            'apepatcon' => 'Apellido Paterno',
            'apematcon' => 'Apellido Materno',
            'emailcon' => 'Email del Contacto',
            'telcon' => 'Telefono del Contacto',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientesContactos()
    {
        return $this->hasMany(ClientesContactos::className(), ['nocontacto' => 'nocontacto']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdctes()
    {
        return $this->hasMany(Clientes::className(), ['idcte' => 'idcte'])->viaTable('clientes_contactos', ['nocontacto' => 'nocontacto']);
    }
}
