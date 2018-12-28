<?php
namespace api\controllers;

use api\models\LoginForm;
use api\models\Project;
use common\models\Addressed;
use common\models\User;
use Yii;
use yii\rest\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use api\models\GetMessageAddressed;
use api\models\SendMessageAddressed;
use api\models\Signup;

/**
 * Site controller
 */
class SiteController extends Controller
{

    public function actionIndex()
    {
        return $public_key = Yii::$app->getSecurity()->generatePasswordHash('123123123');
//        return 'api';
    }

    public function actionGetMessageAddressed()
    {
        $model = new GetMessageAddressed();
        $model->load(Yii::$app->request->getQueryParams(), '');
        if ($getMessage = $model->getMessage()) {
            return $getMessage;
        } else {
            return $model;
        }
    }
    public function actionAuthAddressed()
    {
        $model = new SendMessageAddressed();
        $model->load(Yii::$app->request->bodyParams, '');
        if ($send = $model->sendMessage()) {
            return $send;
        } else {
            return $model;
        }
    }

    public function actionLogin()
    {
        $model = new LoginForm();
        $model->load(Yii::$app->request->bodyParams, '');
        if ($token = $model->auth()) {
            return $token;
        } else {
            return $model;
        }
    }

    protected function verbs()
    {
        return [
            'get-message-addressed' => ['get'],
            'auth-addressed' => ['post'],
            'login' => ['post'],
        ];
    }

    private function findModel($key_message,$key_user)
    {
        return Addressed::find()
            ->innerJoin('addressed', 'message.addressed_id = addressed.id')
            ->where(['addressed.key_message' => $key_message])
            ->andWhere(['key_user' => $key_user])->all();
    }


    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
