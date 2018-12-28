<?php

namespace common\models;

use api\models\Message;
use api\models\Project;
use backend\models\AnsMess;
use Yii;

/**
 * This is the model class for table "addressed".
 *
 * @property int $id
 * @property int $project_id
 * @property string $type_addressed
 * @property string $fio_addressed
 * @property string $token
 * @property int $expired_at
 *
 */
class Addressed extends \yii\db\ActiveRecord
{
    private $securityToken = '123123123';

    public static function tableName()
    {
        return 'addressed';
    }

    public function generateToken($token)
    {
        return $this->token = Yii::$app->security->generateRandomString() . '_' . $token;
    }

    public function generateExpire($expire)
    {
        return $this->expired_at = Yii::$app->security->generateRandomString(). '_' . $expire;
    }

    public function createExpire()
    {
        return $this->expired_at = time();
    }

    public static function  getLastIdAddressed()
    {
        $lastId = static::find()->orderBy('id DESC')->one();
        return $lastId->id;
    }

    public function fields()
    {
        $fields = parent::fields();
        unset($fields['auth_key'], $fields['public_key']);
        return [
            'token' => 'token',

        ];
    }
     public static function findPostAddressed($key_message,$key_user,$type_message)
     {
         return static::find()
             ->innerJoin('addressed', 'message.addressed_id = addressed.id')
             ->where(['addressed.key_message' => $key_message])
             ->andWhere(['addressed.key_user' => $key_user])
             ->andWhere(['addressed.type_message' => $type_message])
             ->one();
     }
     public static function findPostCheckAddressed($key_message,$key_user,$type_message)
     {
         static::find()->where(['key_message'=>$key_message])
             ->andWhere(['key_user'=>$key_user])
             ->andWhere(['type_message'=>$type_message])->one();
     }

    public static function findByAddressed($token)
    {
        return static::findOne(['token' => $token]);
    }

    public static function findByAddressedKeyUser($key_user)
    {
        return static::findOne(['key_user' => $key_user]);
    }

    public static function findByAddressedKeyMessage($key_message)
    {
        return static::findOne(['key_message' => $key_message]);
    }

    public function validateToken($public_key)
    {
        if($this->validatePublicKeyAPI($this->securityToken,$public_key)){
            return true;
        }
        else{
            return false;
        }

    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getProject()
    {
        return $this->hasOne(Project::className(), ['id' => 'project_id']);
    }

    public function getMessages()
    {
        return $this->hasMany(Message::className(), ['addressed_id' => 'id']);
    }

    public function getAnsMesses()
    {
        return $this->hasMany(AnsMess::className(), ['addressed_id' => 'id']);
    }

    public function validatePublicKeyAPI($password, $hash)
    {
        if (!is_string($password) || $password === '') {
            return ('Password must be a string and cannot be empty.');
        }

        if (!preg_match('/^\$2[axy]\$(\d\d)\$[\.\/0-9A-Za-z]{22}/', $hash, $matches)
            || $matches[1] < 4
            || $matches[1] > 30
        ) {
            return false;
        }

        if (function_exists('password_verify')) {
            return password_verify($password, $hash);
        }

        $test = crypt($password, $hash);
        $n = strlen($test);
        if ($n !== 60) {
            return false;
        }

        return Yii::$app->security->compareString($test, $hash);
    }
}
