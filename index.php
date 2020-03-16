<?php
// https://shielded-caverns-80867.herokuapp.com/
// https://git.heroku.com/shielded-caverns-80867.git
echo "It's a new inst-feed-app!";

// new api
$token = 'IGQVJYeXB4WkxDNF9NTEFVaVpheGV5TWlJMUhCTG5NSS1qSnZAJM0dMQlVaM1pGWmp5NEVsMlp1TkQ5NmQ5M2UtNmRSelJ0Vy1mbHZAWVXRUQzhzMVd4MWZAKd05zdXpWX1J3b3V0YmJXZAWdmSlBteTVtaQZDZD';

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
</head>
<body>
	<div>
		<?php foreach($media->data as $key => $mediaObj): ?>
		<img src="<?php echo $mediaObj->media_url; ?>" >
		<?php endforeach; ?>
	</div>
</body>
</html>