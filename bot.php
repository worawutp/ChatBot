<?php
$access_token = 'ycsRyUP3IrJCgcbST29BS8a/tVy8M1r9+OS/ABuVM7C/OBSr7Xu7UeZ4Th+4sQrY1MvE+KWCtaCOe5AKSqkmm1tMfStK+enOTj1Q+xL4KkUMLGWRwQoGm85pc+uDWG2CzJFmxJegeHugpcLE89ypKAdB04t89/1O/w1cDnyilFU=';

// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
if (!is_null($events['events'])) {
	// Loop through each event
	foreach ($events['events'] as $event) {
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			// Get text sent
			$text = $event['message']['text'];
			// Get replyToken
			$replyToken = $event['replyToken'];
			
			// Make a POST Request to Messaging API to reply to sender
			$user = $event['source']['userId'];
			$url = 'https://api.line.me/v2/bot/profile/'.$user;
			$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			$result = curl_exec($ch);
			$result2 = json_decode($result, true);
			curl_close($ch);
			$displayname = $result2['displayName'];
			$day = ['วันนี้','พรุ่งนี้','มะรืนนี้','วันสอบ SM','วันสอบ Ecom','วันพรีเซ้น SM','วันพระ','วันเกิด','วันมาฆบูชา','วันวาเลนไทน์'];
			$predict = ['โชคดี','โชคร้าย','แย่ล้าว','ตื่นสาย','นอนกรน','เที่ยวดึก','เจอเนื้อคู่','สะดุดขี้ฝุ่น','หิวข้าว','ไม่ได้นอน'];
			$lastdigit = substr($user, -1);
			$lastdigit2 = substr($replyToken, -1);
			

			
			// Build message to reply back
			if ( $text == 'ทำนาย' )
			{
				$messages = [
					'type' => 'text',
					'text' => $day[$lastdigit2%10].$displayname.' จะ'.$predict[$lastdigit%10]
				];
			}else
			if ( strpos($text, 'สวัสดี') == 'สวัสดี' )
			{
				$messages = [
					'type' => 'text',
					'text' => 'สวัสดี '.$displayname
				];
			}else if ( $text == 'เริ่ม' )
			{
				$messages = [
					'type' => 'text',
					'text' => 'Hello, world 􀂲'
				];
			}else if(ctype_digit(strval($text)))
			{
				if( $text > 55 )
				{
					$messages = [
						'type' => 'text',
						'text' => 'มันน้อยกว่านี้นะ'
					];
				}else if ( $text < 55 )
				{
					$messages = [
						'type' => 'text',
						'text' => 'มันมากกว่านี้นะ'
					];
				}
				else if ( $text = 55 )
				{
					$messages = [
						'type' => 'text',
						'text' => 'ถูกละ'
					];
				}
			}else
			{
				$messages = [
						'type' => 'sticker',
						'packageId' => '1',
						'stickerId' => '1'
					];
			}
			
			// Make a POST Request to Messaging API to reply to sender
			$url = 'https://api.line.me/v2/bot/message/reply';
			$data = [
				'replyToken' => $replyToken,
				'messages' => [$messages],
			];
			$post = json_encode($data);
			$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			$result = curl_exec($ch);
			curl_close($ch);

			echo $result . "\r\n";
		}
	}
}
echo "OK";
