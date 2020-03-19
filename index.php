<?php
ini_set('error_reporting', 1);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
// https://shielded-caverns-80867.herokuapp.com/
// https://git.heroku.com/shielded-caverns-80867.git

$token = 'IGQVJYeXB4WkxDNF9NTEFVaVpheGV5TWlJMUhCTG5NSS1qSnZAJM0dMQlVaM1pGWmp5NEVsMlp1TkQ5NmQ5M2UtNmRSelJ0Vy1mbHZAWVXRUQzhzMVd4MWZAKd05zdXpWX1J3b3V0YmJXZAWdmSlBteTVtaQZDZD';

$instagram_cnct = curl_init(); // инициализация cURL подключения
curl_setopt( $instagram_cnct, CURLOPT_URL, "https://graph.instagram.com/refresh_access_token?grant_type=ig_refresh_token&access_token=" . $token ); // подключаемся
curl_setopt( $instagram_cnct, CURLOPT_RETURNTRANSFER, 1 ); // просим вернуть результат
curl_setopt( $instagram_cnct, CURLOPT_TIMEOUT, 15 );
$response = json_decode( curl_exec( $instagram_cnct ) ); // получаем и декодируем данные из JSON
curl_close( $instagram_cnct ); // закрываем соединение

echo '<pre>';
print_r($response);
echo '</pre>';

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