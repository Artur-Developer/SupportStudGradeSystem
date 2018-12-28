<?php

namespace api\models;

use Yii;

/**
 * This is the model class for table "project".
 *
 * @property int $id
 * @property string $name_project
 * @property string $description
 *
 * @property Message[] $messages
 */
class Project extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'project';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name_project'], 'required'],
            [['description'], 'string'],
            [['name_project'], 'string', 'max' => 255],
            [['name_project'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name_project' => 'Name Project',
            'description' => 'Description',
        ];
    }

    public static function checkProject($project_name)
    {
        return static::find()->select('id')->addSelect('name_project')->where(['name_project'=>$project_name])->one();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Message::className(), ['project_id' => 'id']);
    }
}
