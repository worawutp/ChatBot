<?php


$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient('ycsRyUP3IrJCgcbST29BS8a/tVy8M1r9+OS/ABuVM7C/OBSr7Xu7UeZ4Th+4sQrY1MvE+KWCtaCOe5AKSqkmm1tMfStK+enOTj1Q+xL4KkUMLGWRwQoGm85pc+uDWG2CzJFmxJegeHugpcLE89ypKAdB04t89/1O/w1cDnyilFU=');
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => 'b96d48f95b963b9d3c9a4f138a4c72f0']);

foreach ($events as $event) {
  $outputText = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('text message');
$bot->replyMessage($event->getReplyToken(), $outputText);
}  
