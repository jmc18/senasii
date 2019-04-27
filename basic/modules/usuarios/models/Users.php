<?php

namespace app\modules\usuarios\models;

use Yii;
use app\modules\clientes\models\Clientes;

/**
 * This is the model class for table "users".
 *
 * @property integer $idusr
 * @property integer $idcte
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string $authkey
 * @property string $accesstoken
 * @property integer $activate
 * @property integer $role
 *
 * @property Clientes $idcte0
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idcte', 'activate', 'role'], 'integer'],
            //[['username', 'email', 'password', 'authkey', 'accesstoken'], 'required'],
            [['username', 'email', 'password'], 'required'],
            [['fechainvitacion'], 'safe'],
            [['username'], 'string', 'max' => 50],
            [['email'], 'string', 'max' => 80],
            [['password', 'authkey', 'accesstoken'], 'string', 'max' => 250],
            [['idcte'], 'exist', 'skipOnError' => true, 'targetClass' => Clientes::className(), 'targetAttribute' => ['idcte' => 'idcte']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idusr' => 'Idusr',
            'idcte' => 'Idcte',
            'username' => 'Username',
            'email' => 'Email',
            'password' => 'Password',
            'authkey' => 'Authkey',
            'accesstoken' => 'Accesstoken',
            'activate' => 'Activate',
            'role' => 'Role',
            'fechainvitacion' => 'Fechainvitacion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdcte0()
    {
        return $this->hasOne(Clientes::className(), ['idcte' => 'idcte']);
    }
}