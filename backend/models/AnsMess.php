<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "ans_mess".
 *
 * @property int $id
 * @property int $addressed_id
 * @property int $answer_message_id
 * @property int $case_number
 *
 * @property AnswerMessage $answerMessage
 * @property Message $message
 */
class AnsMess extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ans_mess';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['message_id', 'answer_message_id', 'addressed_id'], 'required'],
            [['message_id', 'answer_message_id', 'addressed_id'], 'integer'],
            [['answer_message_id'], 'exist', 'skipOnError' => true, 'targetClass' => AnswerMessage::className(), 'targetAttribute' => ['answer_message_id' => 'id']],
            [['message_id'], 'exist', 'skipOnError' => true, 'targetClass' => Message::className(), 'targetAttribute' => ['message_id' => 'id']],
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
            'message_id' => 'addressed ID',
            'answer_addressed_id' => 'Answer Message ID',
            'addressed_id' => 'Case Number',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnswerMessage()
    {
        return $this->hasOne(AnswerMessage::className(), ['id' => 'answer_message_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessage()
    {
        return $this->hasOne(Message::className(), ['id' => 'message_id']);
    }

    public function getAddressed()
    {
        return $this->hasOne(Addressed::className(), ['id' => 'addressed_id']);
    }
}
