<?php

declare(strict_types = 1);

include 'basics.php';

use unreal4u\TelegramAPI\Telegram\Methods\GetMe;
use unreal4u\TelegramAPI\Telegram\Methods\SendMessage;
use unreal4u\TelegramAPI\Telegram\Types\User;
use unreal4u\TelegramAPI\TgLog;

$loop = \React\EventLoop\Factory::create();
$handler = new \unreal4u\TelegramAPI\HttpClientRequestHandler($loop);
$tgLog = new TgLog(BOT_TOKEN, $handler);

$getMe = new GetMe();
$promise = $tgLog->performApiRequest($getMe);

$promise->then(function (User $userInformation) {
    printf(
        'This bot is called <strong>%s</strong> (username %s) and has id <strong>%d</strong>%s',
        $userInformation->first_name,
        $userInformation->username,
        $userInformation->id,
        PHP_EOL
    );
});

$sendMessage = new SendMessage();
$sendMessage->chat_id = A_USER_CHAT_ID;
$sendMessage->text = 'Hello world to the user... now revamped!';
$tgLog->performApiRequest($sendMessage);

$sendMessage = new SendMessage();
$sendMessage->chat_id = A_GROUP_CHAT_ID;
$sendMessage->text = 'And this is an hello the the group... from scratch :D';
$tgLog->performApiRequest($sendMessage);

$loop->run();
