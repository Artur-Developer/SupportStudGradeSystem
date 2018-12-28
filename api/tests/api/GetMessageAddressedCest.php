<?php
/**
 * Created by PhpStorm.
 * User: vipma
 * Date: 18.12.2018
 * Time: 21:36
 */

namespace api\tests\api;
use \api\tests\ApiTester;
use common\fixtures\AnsMessFixture;
use common\fixtures\AnswerMessageFixture;
use common\fixtures\MessageFixture;
use common\fixtures\AddressedFixture;
use common\fixtures\ProjectFixture;
use common\fixtures\UserFixture;

class GetMessageAddressedCest
{
    private $public_key = '$2y$13$..YBg4E/PmQRZ9hytWWCR.y8FwkI8rK.2.XvBicLeuXtIZNfqjcwC';
    private $path_error = '/frontend/web/student/time-table';
    private $user_key = 'V6I_aR2EGemBL9csGdYNy23F1zD3FRIP3';
    private $project = 'ta.studgradesystem';
    private $key_message_user1 = 'XLCc6w3';
    private $key_message_user2 = 'XXBlg44';

    public function _before(ApiTester $I)
    {
        $I->haveFixtures([
            'project' => [
                'class' => ProjectFixture::className(),
                'dataFile' => codecept_data_dir() . 'project.php'
            ],
            'addressed' => [
                'class' => AddressedFixture::className(),
                'dataFile' => codecept_data_dir() . 'addressed.php'
            ],
            'message' => [
                'class' => MessageFixture::className(),
                'dataFile' => codecept_data_dir() . 'message.php'
            ],
            'ans_mess' => [
                'class' => AnsMessFixture::className(),
                'dataFile' => codecept_data_dir() . 'ans_mess.php'
            ],
            'answer_message' => [
                'class' => AnswerMessageFixture::className(),
                'dataFile' => codecept_data_dir() . 'answer_message.php'
            ],
            'user' => [
                'class' => UserFixture::className(),
                'dataFile' => codecept_data_dir() . 'user.php'
            ],
        ]);
    }

    public function badMethodPOST(ApiTester $I)
    {
        $I->sendPOST('/site/get-message-addressed');
        $I->seeResponseCodeIs(405);
        $I->seeResponseIsJson();
    }
    public function wrongPublicKey(ApiTester $I)
    {
        $I->sendGET('/site/get-message-addressed', [
            'project_name' => $this->project,
            'public_key' => 'erf'.$this->public_key,
        ]);
        $I->seeResponseCodeIs(422);
        $I->seeResponseContainsJson([
            'field' => 'public_key',
            'message' => 'Ошибка подключения'
        ]);
    }
    public function emptyPublicKey(ApiTester $I)
    {
        $I->sendGET('/site/get-message-addressed', [
            'project_name' => $this->project,
            'public_key' => '',
        ]);
        $I->seeResponseCodeIs(422);
        $I->seeResponseContainsJson([
            'field' => 'public_key',
            'message' => 'Public Key cannot be blank.'
        ]);
    }
    public function wrongUnknownProject(ApiTester $I)
    {
        $I->sendGET('/site/get-message-addressed', [
            'project_name'=>'unknown.studgradesystem' ,
            'public_key'=> $this->public_key,
            'key_user'=> $this->user_key,
            'key_message'=> $this->key_message_user1,
            'type_message'=> '0',
        ]);
        $I->seeResponseCodeIs(422);
        $I->seeResponseContainsJson([
            'field' => 'project_name',
            'message' => 'Неизвестный проект'
        ]);
    }
    public function emptyProject(ApiTester $I)
    {
        $I->sendGET('/site/get-message-addressed', [
            'project_name' => '',
            'public_key' => '',
        ]);
        $I->seeResponseCodeIs(422);
        $I->seeResponseContainsJson([
            'field' => 'project_name',
            'message' => 'Project Name cannot be blank.'
        ]);
    }
    public function wrongTypeMessage(ApiTester $I)
    {
        $I->sendGET('/site/get-message-addressed', [
            'project_name'=>$this->project,
            'public_key'=> $this->public_key,
            'type_message'=> 'refer',

        ]);
        $I->seeResponseCodeIs(422);
        $I->seeResponseContainsJson([
            'field' => 'type_message',
            'message' => 'Type Message must be an integer.'
        ]);
    }
    public function emptyUserKey(ApiTester $I)
    {
        $I->sendGET('/site/get-message-addressed', [
            'project_name' => $this->project,
            'public_key' => $this->public_key,
            'key_user' => '',
        ]);
        $I->seeResponseCodeIs(422);
        $I->seeResponseContainsJson([
            'field' => 'key_user',
            'message' => 'Key User cannot be blank.'
        ]);
    }

    public function emptyData(ApiTester $I)
    {
        $I->sendGET('/site/get-message-addressed', [
            'project_name'=>$this->project ,
            'public_key'=> $this->public_key,
            'key_user'=> '',
            'key_message'=> '',
            'type_message'=> '',
        ]);
        $I->seeResponseCodeIs(422);

    }

    public function notMessages(ApiTester $I)
    {
        $I->sendGET('/site/get-message-addressed', [
            'project_name'=>$this->project ,
            'public_key'=> $this->public_key,
            'key_user'=> $this->user_key,
            'key_message'=> $this->key_message_user2,
            'type_message'=> '0',
        ]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseContains('Данных нет');

    }

    public function success(ApiTester $I)
    {
        $I->sendGET('/site/get-message-addressed', [
                'project_name'=>$this->project ,
                'public_key'=> $this->public_key,
                'key_user'=> $this->user_key,
                'key_message'=> $this->key_message_user1,
                'type_message'=> '0',
        ]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }
}