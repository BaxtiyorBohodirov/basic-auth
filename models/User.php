<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Query;
use yii\debug\models\search\Db;

class User extends ActiveRecord implements \yii\web\IdentityInterface
{

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    public function fields()
    {
        $fields = parent::fields();
        unset($fields['password_hash'], $fields['auth_key']);

        $fields['created_at'] = function () {
            return $this->formatDate($this->created_at);
        };

        $fields['updated_at'] = function () {
            return $this->formatDate($this->updated_at);
        };

        return $fields;
    }
    public function attributes()
    {
        return ['id', 'username', 'email', 'status', 'created_at', 'updated_at', 'password_hash'];
    }

    public static function tableName() {
        return 'users';
    }
    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
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
        $user = self::find()->where(['username' => $username])->one();
        return $user;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    public function formatDate($date) {
        return date('Y-m-d H:i:s', $date);
    }
}
