<?php

namespace api\controllers;

use common\models\Addressed;
use Yii;
use api\models\Message;
use api\models\MessageSearch;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MessageController implements the CRUD actions for Message model.
 */
class MessageController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator']['authMethods'] = [
            HttpBasicAuth::className(),
            HttpBearerAuth::className(),
        ];
        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'rules' => [
                [
                    'allow' => true,
                    'roles' => ['@'],
                ],
            ],
        ];
        return $behaviors;
    }
//  public function behaviors()
//   {
//       return [
//           'basicAuth' => [
//               'class' => \yii\filters\auth\HttpBasicAuth::className(),
//               'auth' => function ($public_key,$key_message, $key_user) {
//                      $addressed = new Addressed();
//                      if ($addressed->validateToken($public_key)) {
//                          return Addressed::find()->where(['key_message' => $key_message])->one();
//                          }
//                      return null;
//                  },
//           ],
//       ];
//   }

    public function actionGetMessage($key_message,$key_user)
    {
        return $this->findModel($key_message,$key_user);
    }

    public function verbs()
    {
        return [
            'get-message' => ['post'],
        ];
    }

    private function findModel($key_message,$key_user)
    {
        return Addressed::find()
            ->innerJoin('addressed', 'message.addressed_id = addressed.id')
            ->where(['addressed.key_message' => $key_message])
            ->andWhere(['key_user' => $key_user])->all();
    }


}
