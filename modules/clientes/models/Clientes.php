<?php

namespace app\modules\clientes\models;

use Yii;
use app\modules\usuarios\models\Users;

/**
 * This is the model class for table "clientes".
 *
 * @property integer $idcte
 * @property string $nomcte
 * @property string $email
 * @property string $telcte1
 * @property string $telcte2
 * @property string $dircte
 * @property string $edocte
 * @property string $pais
 * @property string $cpcte
 * @property string $sucursal
 * @property string $usrcte
 * @property string $pwdcte
 *
 * @property ClientesContactos[] $clientesContactos
 * @property Contactos[] $nocontactos
 */
class Clientes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'clientes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nomcte', 'email', 'edocte', 'pais', 'sucursal'], 'string', 'max' => 50],
            [['nomcte', 'email', 'edocte', 'pais', 'dircte', 'telcte1'], 'required'],
            [['telcte1', 'telcte2'], 'string', 'max' => 10],
            [['dircte'], 'string', 'max' => 100],
            [['cpcte'], 'string', 'max' => 5],
            [['usrcte', 'pwdcte'], 'string', 'max' => 25],
            [['email'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idcte' => 'Idcte',
            'nomcte' => 'Nombre del Cliente',
            'email' => 'Correo Electrónico',
            'telcte1' => 'Teléfono 1',
            'telcte2' => 'Teléfono 2',
            'dircte' => 'Dirección',
            'edocte' => 'Estado',
            'pais' => 'Pais',
            'cpcte' => 'Código Postal',
            'sucursal' => 'Sucursal',
            'usrcte' => 'Usrcte',
            'pwdcte' => 'Pwdcte',
        ];
    }

   /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalendarioCalibracionClientes()
    {
        return $this->hasMany(CalendarioCalibracionClientes::className(), ['idcte' => 'idcte']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdareas()
    {
        return $this->hasMany(CalendarioCalibracion::className(), ['idarea' => 'idarea', 'idreferencia' => 'idreferencia'])->viaTable('calendario_calibracion_clientes', ['idcte' => 'idcte']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalendarioClientes()
    {
        return $this->hasMany(CalendarioClientes::className(), ['idcte' => 'idcte']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdramas()
    {
        return $this->hasMany(Calendario::className(), ['idrama' => 'idrama', 'idsubrama' => 'idsubrama', 'idanalito' => 'idanalito', 'idreferencia' => 'idreferencia'])->viaTable('calendario_clientes', ['idcte' => 'idcte']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientesContactos()
    {
        return $this->hasMany(ClientesContactos::className(), ['idcte' => 'idcte']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNocontactos()
    {
        return $this->hasMany(Contactos::className(), ['nocontacto' => 'nocontacto'])->viaTable('clientes_contactos', ['idcte' => 'idcte']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCotizaciones()
    {
        return $this->hasMany(Cotizaciones::className(), ['idcte' => 'idcte']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(Users::className(), ['idcte' => 'idcte']);
    }
}
