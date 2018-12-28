<?php
namespace api\models;

use api\models\Message;
use common\models\Addressed;
use Yii;
use yii\base\Exception;
use yii\base\Model;


class GetMessageAddressed extends Model
{
    public $key_message;
    public $key_user;
    public $public_key;
    public $project_name;
    public $type_message;


    public function rules()
    {
        return [
            ['public_key', 'validateToken'],
            ['project_name', 'validateProject'],

            [['type_message'], 'integer'],
            [['key_user','key_message'], 'string', 'max' => 255],
            [['public_key','project_name','key_user',
                'key_message', 'type_message'], 'required'],

        ];
    }

    public function getMessage()
    {
        if ($this->validate()) {
            // пользователь проверен
            if(!empty($this->CheckKeyMessage())){
                // Получаем  сообщения
                $addressed = $this->CheckKeyMessage()->id;
                if(!empty($allMessage = AnsMess::findDialog($addressed))){
                    return $allMessage;
                }
                else{
                    return 'Ошибка';
                }
            }
            else{
                return 'Данных нет';
            }

        } else {
            return null;
        }
    }

    public function CheckKeyMessage()
    {
        if (!$this->hasErrors()) {
            if (
                $data = Addressed::find()->where(['key_message'=>$this->key_message])
                ->andWhere(['key_user'=>$this->key_user])
                ->andWhere(['type_message'=>$this->type_message])->one())
            {
                return $data;
            }
            else{return false;}
        }
        else {
            return false;
        }
    }

    public function validateProject($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $project = new Project();
            if (!$project || !$project->checkProject($this->project_name)) {
                $this->addError($attribute, 'Неизвестный проект');
            }
        }
    }

    public function validateToken($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $Addressed = new Addressed();
            if (!$Addressed || !$Addressed->validateToken($this->public_key)) {
                $this->addError($attribute, 'Ошибка подключения');
            }
        }
    }

}
