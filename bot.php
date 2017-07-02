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
			$error = ['งงดิ','อย่าแกล้งเราสิ','ไม่เข้าใจอ่า','อย่าเยอะ','เรายังไม่ได้เรียนอะไรแบบนี้','ไม่ไหวล้าววว'];
			$SM = ['อย่าไปพูดถึงมันเลย','เฮ้ออออ','#%!@#%$&&*@#$','เพลียยยย','...','ยอมล้าววววว'];
			$sticker = [3,17,101,118,129,420];
			$lastdigit = substr($user, -1);
			$lastdigit2 = substr($replyToken, -1);
			$rand1 = rand(0,5);
			$rand2 = rand(0,1);
			
			
			// Build message to reply back
			if ( strpos($text, 'ทำนาย') == 'ทำนาย' and  ctype_digit(strval(substr($text,-5))) )
			{
				
				$messages = [
					'type' => 'text',
					'text' => $day[substr($text,-5)%10].$displayname.' จะ'.$predict[substr($text,-5,4)%10]
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
			}else if(strpos($text,'หิว') == 'หิว')
			{
				$messages =[
				    'type' => 'image',
				    'originalContentUrl' => 'https://lh3.googleusercontent.com/qqqCQN_bmH0MXXeyLB9mVNsy4H4PcBEu23FK8mXmUrdE9IbjtvGthLql_EDiBa-OhqHnhZJggOlJww-MjvSFXMX4ky8bMvKdYS0mfHCU6XdwJ0K_jaR4y4366ZXOhDHc9XQC2blu3ZE9lYZY40HwICvMERQ_I4CLE1Yif-qEFG66sD-HHoTB5Gm_w3PlL0DktR4ymoHX_z6bs99ifmQl7ZnjJ2XGdCANuZZsSjCigqZOUYkdMVztCYvQpqu3BdKiaikVaEmTgHVWv4extdDCfBI2kTw06k57-W4KvIBP24ngr18jSTO_cWotp5xr3__J9gNWf_zmTyUPOnrEUKVWeDtiIyAhnwxo5Gi_tlAJ79-Q62rxIGqhYUauZ3RpJfwL6xi7YmeNMD7DH2jfRPIJ3RU7LVvRJaEsfapK1aLvPpWpZ2dSwaucPpvftfHbSGJsQk4Gchu5M5E3ciOSvKp_o6yBKSZaZhjYHkKkfWUWOQ5zoN0XUvnVsgDQt699E-hL658LEaMwJ6iQTy7gFhjt5jSekIj3FphALLQuKVsp3Ca1K3jYF8jp1al1KhhiWOohEKoyd18DJ_RpxmoKFhgJdHrY8Vq-sNrhuv-HsF5ttI54PuCaVmIG=w861-h638-no',
				    'previewImageUrl' => 'https://lh3.googleusercontent.com/EcYGJGoXQBZ5Avd3ahY11fNIcVcLMPOEgvIUEvoxabWB3ekSdaUfOZ3i2rPvdkfuv38-diLT7GFrPCkB1edvbJ5YnOEMugix4xA5n8_fHIi6VZ7uaavhpWHQfJjaXTkfRLM-JqwKN-jR6CH5kKyStPxqcGD9PofJ4rsRal1bgUHVXZbTvRaUYKaKwluATW0GUAuB7SWMrvnHi2Uri81eHPjSz3P_d_jjJmwJTYOqyR1DYyoJ0Ax9cxdblZrd9NR0V8PP4iQi6sMDaMHICdkH0GeO5hdEomo_AJy5XJ0CMUGvw29v9ZlFh0yhH0qfcNRFUQagmIFMIPE8CBLCY090o6MlyQVaxKzSOUbmHGUX6Eo7zO6UrVzxLEnB-5cnwoPWtGuK5WljTEpelSYleyO_1GPuIu4QY1FfDL4zVk4QU6wV9cdLFVY_filXDRvKOpP4bsup9KJwzKVCieF-gwPCSiTypySN5NcyF32a9RRAcmCzBLHuWmP6mPNDLjyfelWYuhriXZuE9cekWS78CEyrvy4cVEZ-HHsRXxE99ZG-RXeIKih6k4kIvlg-U_YwLYTpJJ9jYhisAA2QXMzSSWNCHtL00DE8mr4dZeKhH01a1lfNqL4a=w240-h177-no'
				];
			}else if(strpos($text,'SM') == 'SM' or strpos($text,'sm') == 'sm')
			{
				$messages = [
					
					'type' => 'text',
					'text' => $SM[$rand1]
					];
			}else if(strpos($text,'ถาม') == 'ถาม')
			{
				$messages = [
					
					'type' => 'text',
					'text' => 'เราไม่รู้หรอกถามอาจารย์มะ'
					];
			}
			else
			{
				if($rand2==0)
				{
				$messages = [
					'type' => 'sticker',
						'packageId' => '1',
						'stickerId' => $sticker[$rand1]
					
					];
				}else
					
				{
				$messages = [
					
					'type' => 'text',
						'text' => $error[$rand1]
					];
				}
		
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
