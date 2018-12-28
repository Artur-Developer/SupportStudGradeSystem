<?php

/**
 * Created by PhpStorm.
 * User: vipma
 * Date: 15.12.2018
 * Time: 13:00
 */
namespace api\models;

use Yii;
use common\models\User;
use yii\base\Model;

/**
 * Signup form
 */
class Signup extends Model
{
    public $username;
    public $email;
    public $last_name;
    public $first_name;
    public $middle_name;
    public $password;
    public $password_repeat;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            [['username','last_name','first_name','middle_name'], 'required'],
            ['username', 'unique', 'targetClass' => 'common\models\User', 'message' => 'Это имя пользователя уже занято.'],
            [['username','last_name','first_name','middle_name'], 'string', 'min' => 5, 'max' => 255],


            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => 'common\models\User', 'message' => 'Этот адрес электронной почты уже занят.'],

            [['password','password_repeat'], 'required'],
            [['password','password_repeat'], 'string', 'min' => 8],
            ['password_repeat','compare', 'compareAttribute' => 'password','message'=>'Пароли не совподают']
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Логин',
            'last_name' => 'Фамилия',
            'first_name' => 'Имя',
            'middle_name' => 'Отчество',
            'Email' => 'Email',
            'password' => 'Пароль',
            'password_repeat' => 'Проверка пароля',
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->last_name = $this->last_name;
            $user->first_name = $this->first_name;
            $user->middle_name = $this->middle_name;
            $user->setPassword($this->password);
            $user->generateAuthKey();

        }

        return null;
    }
}
