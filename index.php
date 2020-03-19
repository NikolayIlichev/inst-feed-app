<?php
ini_set('error_reporting', 1);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
// https://shielded-caverns-80867.herokuapp.com/
// https://git.heroku.com/shielded-caverns-80867.git
$redirectUri = 'https://shielded-caverns-80867.herokuapp.com/';
$clientId = '226153611904886';
$clientSecret = '8e46c3ef00ba8c01baaf1f33e0cf39fc';
?>
<a href="https://api.instagram.com/oauth/authorize?client_id=<?php echo $clientId; ?>&redirect_uri=<?php echo $redirectUri; ?>&scope=user_profile,user_media&response_type=code"></a>
<?php

// if (!empty($_GET['code'])) {
// 	$code = htmlspecialchars(trim($_GET['code']));
// 	if( $curl = curl_init() ) {
// 		$fields = 'client_id=' . $clientId . '&client_secret=' . $clientSecret . '&code=' . $code . '&grant_type=authorization_code&redirect_uri=' . $redirectUri;
// 	    curl_setopt($curl, CURLOPT_URL, 'https://api.instagram.com/oauth/access_token');
// 	    curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
// 	    curl_setopt($curl, CURLOPT_POST, true);
// 	    curl_setopt($curl, CURLOPT_POSTFIELDS, $fields);
// 	    $response = json_decode(curl_exec($curl));
// 	    curl_close($curl);
// 	}
// } elseif (!empty($_GET['error'])) {
// 	echo "Auth error";
// }

// if (!empty($response['access_token'])) {
// 	echo '<pre>';
// 	print_r($response);
// 	echo '</pre>';
// 	if( $curl = curl_init() ) {
// 		$fields = '?grant_type=ig_exchange_token&client_secret=' . $clientSecret . '&access_token=' . $response['access_token'];
// 	    curl_setopt($curl, CURLOPT_URL, 'https://graph.instagram.com/access_token');
// 	    curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
// 	    curl_setopt($curl, CURLOPT_POST, true);
// 	    curl_setopt($curl, CURLOPT_POSTFIELDS, $fields);
// 	    $response = json_decode(curl_exec($curl));
// 	    curl_close($curl);
// 	}
// }

// if (!empty($response['access_token'])) {
// 	echo '<pre>';
// 	print_r($response);
// 	echo '</pre>';
// }

// $token = 'IGQVJXaXU3ZA0xVQzh0a0wwSDBkS1pOOVJnd1R6WjZAzZA2pXNXZAUbEljYlhWa1dSSE9MRDFGUkJhR2R6R1puQkpYTkhZAX1VmN2w3djN1TDMwSjZAJbXh0U1ZAPbGZAvaHl0VFRGdUFsWVh3';

// $instagram_cnct = curl_init(); // инициализация cURL подключения
// curl_setopt( $instagram_cnct, CURLOPT_URL, "https://graph.instagram.com/refresh_access_token?grant_type=ig_refresh_token&access_token=" . $token ); // подключаемся
// curl_setopt( $instagram_cnct, CURLOPT_RETURNTRANSFER, 1 ); // просим вернуть результат
// curl_setopt( $instagram_cnct, CURLOPT_TIMEOUT, 15 );
// $response = json_decode( curl_exec( $instagram_cnct ) ); // получаем и декодируем данные из JSON
// curl_close( $instagram_cnct ); // закрываем соединение

// echo '<pre>';
// print_r($response);
// echo '</pre>';

/*
echo "It's a new inst-feed-app!";

// new api
$token = 'IGQVJYeXB4WkxDNF9NTEFVaVpheGV5TWlJMUhCTG5NSS1qSnZAJM0dMQlVaM1pGWmp5NEVsMlp1TkQ5NmQ5M2UtNmRSelJ0Vy1mbHZAWVXRUQzhzMVd4MWZAKd05zdXpWX1J3b3V0YmJXZAWdmSlBteTVtaQZDZD';

if (!empty($token)) 
{
	// get media data from token owner account
	$instagram_cnct = curl_init(); // инициализация cURL подключения
	curl_setopt( $instagram_cnct, CURLOPT_URL, "https://graph.instagram.com/me/media?fields=id,media_type,media_url,caption,timestamp,thumbnail_url&access_token=" . $token ); // подключаемся
	curl_setopt( $instagram_cnct, CURLOPT_RETURNTRANSFER, 1 ); // просим вернуть результат
	curl_setopt( $instagram_cnct, CURLOPT_TIMEOUT, 15 );
	$media = json_decode( curl_exec( $instagram_cnct ) ); // получаем и декодируем данные из JSON
	curl_close( $instagram_cnct ); // закрываем соединение

	// Refresh a long-lived Instagram User Access Token that is at least 24 hours old but has not expired. Refreshed tokens are valid for 60 days from the date at which they are refreshed.
	
	echo "<pre>";
	print_r($media);
	echo "</pre>";
	
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>

	<style>
		.images__wrapper {
			display: flex;
			flex-wrap: wrap;
		}

		.image__block {
			width: 200px;
    		height: 200px;
    		background-size: cover;
		}
	</style>
</head>
<body>
	<div class="images__wrapper">
		<?php foreach($media->data as $key => $mediaObj): ?>
		<div class="image__block" style="background-image: url(<?php echo $mediaObj->thumbnail_url ?: $mediaObj->media_url; ?>)"></div>
		<?php endforeach; ?>
	</div>
</body>
</html>