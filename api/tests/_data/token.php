<?php
/**
 * Created by PhpStorm.
 * User: vipma
 * Date: 18.12.2018
 * Time: 21:35
 */
return [
    [
        'user_id' => 1,
        'token' => 'token-correct',
        'expired_at' => time() + 3600,
    ],
    [
        'user_id' => 1,
        'token' => 'token-expired',
        'expired_at' => time() - 3600,
    ],
];