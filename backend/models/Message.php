<?php

namespace backend\models;

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
            [[ 'addressed_id','message'], 'required'],
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
