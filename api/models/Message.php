<?php

namespace api\models;

use common\models\Addressed;
use Yii;

/**
 * This is the model class for table "message".
 *
 * @property int $id
 * @property int $project_id
 * @property int $addressed_id
 * @property string $type_addressed
 * @property string $fio_addressed
 * @property int $type_message
 * @property string $image
 * @property string $message
 * @property string $path_error
 *
 * @property AnsMess[] $ansMesses
 * @property Project $project
 */
class Message extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'message';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[ 'addressed_id'], 'integer'],
            [['message'], 'string'],
            [['image'], 'string', 'max' => 255],
            ['create_date', 'datetime', 'format' => 'php:Y-m-d H:i:s'],
            [['addressed_id'], 'exist', 'skipOnError' => true, 'targetClass' => Addressed::className(), 'targetAttribute' => ['addressed_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'addressed_id' => 'Addressed ID',
            'image' => 'Image',
            'message' => 'Message',
            'create_date' => 'Дата',
        ];
    }

    public function SaveDataApi($addressed_id,$message)
    {
        if($this->validate()){
            $this->addressed_id = intval($addressed_id);
            $this->message = $message;
            return $this->save() ? $this : null;
        }
        else{
            $this->addError('Ошибка валидации');
            return false;
        }
    }

    public static function findByDublicateMessage($key_message,$message,$type_message,$path_error)
    {

        return static::find()->select('id', 'addressed_id')
            ->innerJoin('addressed', 'message.addressed_id = addressed.id')
            ->where(['addressed.key_message' => $key_message])
            ->andWhere(['addressed.type_message' => $type_message])
            ->andWhere(['path_error' => $path_error])
            ->andWhere(['message' => $message])->one();

    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnsMesses()
    {
        return $this->hasMany(AnsMess::className(), ['message_id' => 'id']);
    }

    public function getAddressed()
    {
        return $this->hasOne(Addressed::className(), ['id' => 'addressed_id']);
    }


}
