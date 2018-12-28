<?php
/**
 * Created by PhpStorm.
 * User: vipma
 * Date: 18.12.2018
 * Time: 21:36
 */

namespace api\tests\api;
use \api\tests\ApiTester;
use common\fixtures\TokenFixture;
use common\fixtures\ProjectFixture;
class SendMessageAddressedCest
{
    private $public_key = '$2y$13$..YBg4E/PmQRZ9hytWWCR.y8FwkI8rK.2.XvBicLeuXtIZNfqjcwC';
    private $path_error = '/frontend/web/student/time-table';
    private $user_key = 'V6I_aR2EGemBL9csGdYNy23F1zD3FRIP';
    private $project = 'ta.studgradesystem';

    public function _before(ApiTester $I)
    {
        $I->haveFixtures([
            'project' => [
                'class' => ProjectFixture::className(),
                'dataFile' => codecept_data_dir() . 'project.php'
            ],
//            'token' => [
//                'class' => TokenFixture::className(),
//                'dataFile' => codecept_data_dir() . 'token.php'
//            ],
        ]);
    }

    public function badMethodGET(ApiTester $I)
    {
        $I->sendGET('/site/auth-addressed');
        $I->seeResponseCodeIs(405);
        $I->seeResponseIsJson();
    }
    public function wrongPublicKey(ApiTester $I)
    {
        $I->sendPOST('/site/auth-addressed', [
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
        $I->sendPOST('/site/auth-addressed', [
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
        $I->sendPOST('/site/auth-addressed', [
            'project_name'=>'unknown.studgradesystem' ,
            'public_key'=> $this->public_key,
            'key_user'=> $this->user_key,
            'key_message'=> 'XLCc6w',
            'type_message'=> '0',
            'type_addressed'=> 'prepod',
            'fio_addressed'=> 'Fazylov A.E.',
            'message'=> 'hello my  site',
            'path_error'=> $this->path_error,

        ]);
        $I->seeResponseCodeIs(422);
        $I->seeResponseContainsJson([
            'field' => 'project_name',
            'message' => 'Неизвестный проект'
        ]);
    }
    public function emptyProject(ApiTester $I)
    {
        $I->sendPOST('/site/auth-addressed', [
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
        $I->sendPOST('/site/auth-addressed', [
            'project_name'=>'ta.studgradesystem' ,
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
        $I->sendPOST('/site/auth-addressed', [
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
        $I->sendPOST('/site/auth-addressed', [
            'project_name'=>$this->project ,
            'public_key'=> $this->public_key,
            'key_user'=> '',
            'key_message'=> '',
            'type_message'=> '',
            'type_addressed'=> '',
            'fio_addressed'=> '',
            'message'=> '',
            'path_error'=> ''
        ]);
        $I->seeResponseCodeIs(422);
    }

    public function success(ApiTester $I)
    {
        $I->sendPOST('/site/auth-addressed', [
                'project_name'=>$this->project ,
                'public_key'=> $this->public_key,
                'key_user'=> $this->user_key,
                'key_message'=> 'XLCc6w',
                'type_message'=> '0',
                'type_addressed'=> 'prepod',
                'fio_addressed'=> 'Fazylov A.E.',
                'message'=> 'My  first message. Hello my site',
                'path_error'=> $this->path_error,

        ]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContains('Данные успешно записаны');
//        $I->seeResponseJsonMatchesJsonPath('$.project_id');
    }
}