<?php

namespace app\models;

class User extends \yii\base\Object implements \yii\web\IdentityInterface
{
    public $idusr;
    public $username;
    public $email;
    public $password;
    public $authkey;
    public $accesstoken;
    public $activate;
    public $verification_code;
    public $role;
    public $idcte;
    public $fechainvitacion;

    /*private static $users = [
        '100' => [
            'id' => '100',
            'username' => 'admin',
            'password' => 'admin',
            'authKey' => 'test100key',
            'accessToken' => '100-token',
        ],
        '101' => [
            'id' => '101',
            'username' => 'demo',
            'password' => 'demo',
            'authKey' => 'test101key',
            'accessToken' => '101-token',
        ],
    ];*/


    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        //return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
          $user = Users::find()
                ->where("activate=:activate", [":activate" => 1])
                ->andWhere("idusr=:id", ["id" => $id])
                ->one();
         return isset($user) ? new static($user) : null;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        /*foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }
        return null;*/

        $users = Users::find()
                ->where("activate=:activate", [":activate" => 1])
                ->andWhere("accesstoken=:accessToken", [":accessToken" => $token])
                ->all();

        foreach ($users as $user) {
            if ($user->accesstoken === $token) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        /*foreach (self::$users as $user) {
            if (strcasecmp($user['username'], $username) === 0) {
                return new static($user);
            }
        }
        return null;*/

        $users = Users::find()
                ->where("activate=:activate", ["activate" => 1])
                ->andWhere("username=:username", [":username" => $username])
                ->all();

        foreach ($users as $user) {
            if (strcasecmp($user->username, $username) === 0) {
                return new static($user);
            }
        }
        return null;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->idusr;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authkey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authkey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        //return $this->password === $password;
        if (crypt($password, $this->password) == $this->password)
        {
            return $password === $password;
        }
    }

    public static function isUserAdmin($id)
    {
        # Revisa si existe el usuario (id), si su cuenta esta activa o confirmada (active) y si es Admin (role = 2)
        if (Users::findOne(['idusr' => $id, 'activate' => '1', 'role' => 2])){
            return true;
        } 
        else { return false; }
    }

    public static function isUserSimple($id)
    {
        if (Users::findOne(['idusr' => $id, 'activate' => '1', 'role' => 1])){
            return true;
        } else { return false; }
    }
}
