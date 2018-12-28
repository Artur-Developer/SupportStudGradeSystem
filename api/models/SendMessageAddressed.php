<?php
namespace api\models;

use api\models\Message;
use common\models\Addressed;
use Yii;
use yii\base\Exception;
use yii\base\Model;

class SendMessageAddressed extends Model
{
    public $key_message;
    public $key_user;
    public $public_key;
    public $project_name;

    public $type_message;
    public $message;
    public $path_error;
    public $fio_addressed;
    public $type_addressed;


    public function rules()
    {
        return [
            ['public_key', 'validateToken'],
            ['project_name', 'validateProject'],

            [['type_addressed'], 'string', 'max' => 100],
            [['type_message'], 'integer'],
            [['fio_addressed', 'key_user','key_message','message','path_error'], 'string', 'max' => 255],
            [['public_key','project_name','key_user','key_message','type_addressed',
                'fio_addressed','type_message','message'], 'required'],

        ];
    }

    public function sendMessage()
    {
        if ($this->validate()) {
            $Addressed = new Addressed();
            $Message = new Message();


            // пользователь уже ранее отсылал эту заявку
            if(!$this->validateKeyUser()){
                if($this->CheckKeyMessage()){
                    if($this->CheckDublicateMessage()){
                        return 'Попытка повторного сохранения';
                    }
                    // Сохраняем текст сообщения
                    $addressed_id = Addressed::findByAddressedKeyUser($this->key_user)->id;
                    if($Message->SaveDataApi($addressed_id,$this->message)){
                        return 'Данные успешно записаны';
                    }
                    else{
                        return 'Ошибка сохранения данных';
                    }
                }

            }
            // если первый запрос от пользователя
            else if($this->validateKeyUser()){
                    $Addressed->type_addressed = $this->type_addressed;
                    $Addressed->type_message = $this->type_message;
                    $Addressed->fio_addressed = $this->fio_addressed;
                    $Addressed->key_user = $this->key_user;
                    $Addressed->key_message = $this->key_message;
                    $Addressed->path_error = $this->path_error;
                    $Addressed->project_id = Project::checkProject($this->project_name)->id;
                    $Addressed->createExpire();
                    $Addressed->generateToken(time() + 3600 * 24);
                    if($Addressed->save()){
                        sleep(0.001);
                        $addressed_id = Addressed::findByAddressedKeyUser($this->key_user)->id;
                        if($Message->SaveDataApi($addressed_id,$this->message)){

                            return 'Данные успешно записаны';
                        }
                        else{
                            return 'Ошибка сохранения данных';
                        }
                    }
            }


        } else {
            return null;
        }
    }

    public function validateKeyUser()
    {
        if (!$this->hasErrors()) {
            if (empty(Addressed::findByAddressedKeyUser($this->key_user))) {
                return true;
            }
            else{return false;}
        }
    }
    public function CheckKeyMessage()
    {
        if (!$this->hasErrors()) {
            if (!empty(Addressed::findByAddressedKeyMessage($this->key_message))) {
                return true;
            }
            else{return false;}
        }
    }
    public function CheckDublicateMessage()
    {
        if (!$this->hasErrors()) {
            if (!empty(Message::findByDublicateMessage($this->key_message,$this->message,$this->type_message,$this->path_error))) {
                return true;
            }
            else{return false;}
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
