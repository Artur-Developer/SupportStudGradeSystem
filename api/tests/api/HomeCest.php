<?php
/**
 * Created by PhpStorm.
 * User: vipma
 * Date: 18.12.2018
 * Time: 0:21
 */

namespace api\tests\api;

use api\tests\ApiTester;

class HomeCest
{
    public function mainPage(ApiTester $I)
    {
        $I->sendGET('/site/index');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }
}