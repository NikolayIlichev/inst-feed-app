<?php

// old api
/*
$token = 'IGQVJVYVVfOU45V1ozUzkyUE1xazNRQ09kYi0xckU3SUZAnOG5GcmY3NVJ5ZAS03R2xLemZAjcV96UG1jZA2ZAXem1Gd0h0Yk9CRnRFa1ZA0RzU2T1ctdGZAkbFk2d0JCRGZADWWxwSldjX1JfOFdILUhfV1lpUgZDZD';
if (!empty($token)) 
{
	$user_id = 'self';
	$instagram_cnct = curl_init(); // инициализация cURL подключения
	curl_setopt( $instagram_cnct, CURLOPT_URL, "https://api.instagram.com/v1/users/" . $user_id . "/media/recent?access_token=" . $token ); // подключаемся
	curl_setopt( $instagram_cnct, CURLOPT_RETURNTRANSFER, 1 ); // просим вернуть результат
	curl_setopt( $instagram_cnct, CURLOPT_TIMEOUT, 15 );
	$media = json_decode( curl_exec( $instagram_cnct ) ); // получаем и декодируем данные из JSON
	curl_close( $instagram_cnct ); // закрываем соединение

	$arImages = array();
	foreach($media->data as $data) {
		if(!empty($insta['tag']))
		{
			if (in_array($insta['tag'], $data->tags)) 
			{			
				$arImages[] = $data->images->low_resolution->url;
			}
		}
		elseif($data->type == 'image')
		{
			$arImages[] = $data->images->low_resolution->url;
		}
		if (count($arImages) == 12) 
		{
			break;
		}
	}
}
*/

// new api
function getInstaFeed() {
  $accessToken = 'IGQVJXZAzR0ekJzOWNodEFiSG9hQWRtM3Q2ZA1RvTXRIUUY2aHlPLXlBNkl6MUZAFQW9lYzBiQ3FmQ0pVUFdoZAlh5RUdETkQxMDZAiSmozZA1pVdmNKUXRuQ1J4RGdZANVFHV29fbWxOYWhn'; // получаем токен
  $tokenDate = '19.05.2020'; // получаем дату создания
  $tokenTimestamp = strtotime($tokenDate);
  $curTimestamp = time();
  $dayDiff = ($curTimestamp - $tokenTimestamp) / 86400;

  if (!empty($accessToken)) {
    if ($dayDiff > 50) {

      // Refresh a long-lived Instagram User Access Token that is at least 24 hours old but has not expired. Refreshed tokens are valid for 60 days from the date at which they are refreshed.
      $instagram_cnct = curl_init(); // инициализация cURL подключения
      curl_setopt( $instagram_cnct, CURLOPT_URL, "https://graph.instagram.com/refresh_access_token?grant_type=ig_refresh_token&access_token=" . $accessToken ); // адрес запроса
      curl_setopt( $instagram_cnct, CURLOPT_RETURNTRANSFER, 1 ); // просим вернуть результат
      curl_setopt( $instagram_cnct, CURLOPT_TIMEOUT, 15 ); // максимальное время, в течение которого разрешено принимать запрос
      $response = json_decode( curl_exec( $instagram_cnct ) ); // получаем и декодируем данные из JSON
      curl_close( $instagram_cnct ); // закрываем соединение

      // обновляем токен и дату его создания в базе

      $accessToken = 'new_token'; // обновленный токен
    }

    // get media data from token owner account
    $instagram_cnct = curl_init(); // инициализация cURL подключения
    curl_setopt( $instagram_cnct, CURLOPT_URL, "https://graph.instagram.com/me/media?fields=id,media_type,media_url,caption,timestamp,thumbnail_url,permalink,children{fields=id,media_url,thumbnail_url,permalink}&limit=50&access_token=" . $accessToken ); // подключаемся
    // curl_setopt( $instagram_cnct, CURLOPT_URL, "https://graph.instagram.com/me/media?fields=id,media_type,media_url,caption,timestamp,thumbnail_url,permalink,children&access_token=" . $accessToken );
    curl_setopt( $instagram_cnct, CURLOPT_RETURNTRANSFER, 1 ); // просим вернуть результат
    curl_setopt( $instagram_cnct, CURLOPT_TIMEOUT, 15 );
    $media = json_decode( curl_exec( $instagram_cnct ) ); // получаем и декодируем данные из JSON
    curl_close( $instagram_cnct ); // закрываем соединение

    // $instaFeed = array();
    // foreach ($media->data as $mediaObj) {
    //   if (!empty($mediaObj->children)) {
    //     foreach ($mediaObj->children->data as $children) {
    //       $instaFeed[$children->id]['img'] = $children->thumbnail_url ?: $children->media_url;
    //       $instaFeed[$children->id]['link'] = $children->permalink;
    //     }
    //   } else {
    //     $instaFeed[$mediaObj->id]['img'] = $mediaObj->thumbnail_url ?: $mediaObj->media_url;
    //     $instaFeed[$mediaObj->id]['link'] = $mediaObj->permalink;
    //   }
    // }

    echo "<pre>";
    print_r($media);
    echo "</pre>";

    return $media;
  }

  return false;
}

getInstaFeed();
/*
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
</head>
<body>
  <?php foreach ($instaFeed as $img): ?>
  
  <img src="<?php $img['img']; ?>">

  <?php endforeach; ?>
</body>
</html>

<?php */?>