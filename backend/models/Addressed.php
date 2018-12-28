<?php

namespace backend\models;

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
 * @property Project $project
 * @property Message[] $messages
 */
class Addressed extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'addressed';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['project_id', 'type_addressed', 'type_message' ,'fio_addressed', 'token', 'expired_at'], 'required'],
            [['project_id', 'expired_at', 'type_message'], 'integer'],
            [['type_addressed'], 'string', 'max' => 100],
            [['fio_addressed', 'token','key_message','path_error'], 'string', 'max' => 255],
            [['token','key_message'], 'unique'],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['project_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'project_id' => 'Project ID',
            'key_message' => 'key_message',
            'type_addressed' => 'Type Addressed',
            'type_message' => 'Type Message',
            'fio_addressed' => 'Fio Addressed',
            'path_error' => 'Пусть ошибки',
            'token' => 'Token',
            'expired_at' => 'Expired At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['id' => 'project_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Message::className(), ['addressed_id' => 'id']);
    }

    public function getAnsMesses()
    {
        return $this->hasMany(AnsMess::className(), ['addressed_id' => 'id']);
    }
}
