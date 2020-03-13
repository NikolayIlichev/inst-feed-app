<?php
// https://shielded-caverns-80867.herokuapp.com/
// https://git.heroku.com/shielded-caverns-80867.git
echo "It's a new inst-feed-app!";

// new api
$token = 'IGQVJWQ3FRTmd6UVI2d1owMDZAHWWJyZA0FTYnpjRVh1dFpQNURxeGlDQTVSSE40MkF1djBudk02TjVXdW9kUWg5c0xOVFBvYXBjeWk0dElUOGpPU0xfT09ZAWTlvTnZAudlpsbGJRS1ZAGeFFCYjRCTGZAXbwZDZD';

if (!empty($token)) 
{
	// get media data from token owner account
	$instagram_cnct = curl_init(); // инициализация cURL подключения
	curl_setopt( $instagram_cnct, CURLOPT_URL, "https://graph.instagram.com/me/media?fields=id,media_type,media_url,caption,timestamp&access_token=" . $token ); // подключаемся
	curl_setopt( $instagram_cnct, CURLOPT_RETURNTRANSFER, 1 ); // просим вернуть результат
	curl_setopt( $instagram_cnct, CURLOPT_TIMEOUT, 15 );
	$media = json_decode( curl_exec( $instagram_cnct ) ); // получаем и декодируем данные из JSON
	curl_close( $instagram_cnct ); // закрываем соединение

	// Refresh a long-lived Instagram User Access Token that is at least 24 hours old but has not expired. Refreshed tokens are valid for 60 days from the date at which they are refreshed.
	// $instagram_cnct = curl_init(); // инициализация cURL подключения
	// curl_setopt( $instagram_cnct, CURLOPT_URL, "https://graph.instagram.com/me/media?fields=id,media_type,media_url,caption,timestamp&access_token=" . $token ); // подключаемся
	// curl_setopt( $instagram_cnct, CURLOPT_RETURNTRANSFER, 1 ); // просим вернуть результат
	// curl_setopt( $instagram_cnct, CURLOPT_TIMEOUT, 15 );
	// $media = json_decode( curl_exec( $instagram_cnct ) ); // получаем и декодируем данные из JSON
	// curl_close( $instagram_cnct ); // закрываем соединение
	echo "<pre>";
	print_r($media);
	echo "</pre>";
	
}