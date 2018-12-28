<?php

namespace api\models;

use backend\models\Addressed;
use Yii;

/**
 * This is the model class for table "ans_mess".
 *
 * @property int $id
 * @property int $message_id
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
            'message_id' => 'message ID',
            'answer_message_id' => 'Answer Message ID',
            'addressed_id' => 'Case Number',
        ];
    }

    public static function findDialog($addressed_id)
    {
        $query = Yii::$app->db->createCommand('
        (SELECT message,create_date FROM `message` WHERE addressed_id='.$addressed_id.')
            UNION
        (SELECT answer_message.answer_message,answer_message.create_date FROM `ans_mess`
        LEFT JOIN `answer_message` ON ans_mess.answer_message_id=answer_message.id WHERE addressed_id='.$addressed_id.')
        ORDER BY create_date DESC')->queryAll();

         return $query;

    }
//    public static function findAllMessage2($addressed_id)
//    {
//
//        $a = Message::find()
//            ->select('message,create_date')
//            ->where(['addressed_id' => $addressed_id]);
//
//        $b = AnsMess::find()
//        ->select('answer_message.answer_message,answer_message.create_date')
//        ->leftJoin('answer_message', 'ans_mess.answer_message_id = answer_message.id')
//        ->where(['ans_mess.addressed_id' => $addressed_id]);
//
//        return $a->union($b)->orderBy('create_date')->all();
//    }

    public function getAnswerMessage()
    {
        return $this->hasOne(AnswerMessage::className(), ['id' => 'answer_message_id']);
    }

    public function getMessage()
    {
        return $this->hasOne(Message::className(), ['id' => 'message_id']);
    }

    public function getAddressed()
    {
        return $this->hasOne(Addressed::className(), ['id' => 'addressed_id']);
    }
}
