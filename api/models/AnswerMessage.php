<?php

namespace api\models;

use common\models\User;
use Yii;

/**
 * This is the model class for table "answer_message".
 *
 * @property int $id
 * @property int $support_user_id
 * @property string $answer_message
 * @property string $image
 *
 * @property AnsMess[] $ansMesses
 * @property User $supportUser
 */
class AnswerMessage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'answer_message';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['support_user_id'], 'required'],
            [['support_user_id'], 'integer'],
            [['answer_message'], 'string'],
            [['image'], 'string', 'max' => 255],
            ['create_date', 'datetime', 'format' => 'php:Y-m-d H:i:s'],
            [['support_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['support_user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'support_user_id' => 'Support User ID',
            'answer_message' => 'Answer Message',
            'image' => 'Image',
            'create_date' => 'Дата',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnsMesses()
    {
        return $this->hasMany(AnsMess::className(), ['answer_message_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSupportUser()
    {
        return $this->hasOne(User::className(), ['id' => 'support_user_id']);
    }
}
