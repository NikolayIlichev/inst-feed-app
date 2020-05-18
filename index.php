<?php

// old api
$token = get_field('access_key', 249);
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


// new api
function getInstaFeed() {
  $accessToken = get_field('access_token', 'options');
  $tokenDate = get_field('token_timestamp', 'options');
  $tokenTimestamp = strtotime($tokenDate);
  $curTimestamp = time();
  $dayDiff = ($curTimestamp - $tokenTimestamp) / 86400;

  if (!empty($accessToken)) {
    if ($dayDiff > 50) {

      // Refresh a long-lived Instagram User Access Token that is at least 24 hours old but has not expired. Refreshed tokens are valid for 60 days from the date at which they are refreshed.
      $instagram_cnct = curl_init(); // инициализация cURL подключения
      curl_setopt( $instagram_cnct, CURLOPT_URL, "https://graph.instagram.com/refresh_access_token?grant_type=ig_refresh_token&access_token=" . $accessToken ); // подключаемся
      curl_setopt( $instagram_cnct, CURLOPT_RETURNTRANSFER, 1 ); // просим вернуть результат
      curl_setopt( $instagram_cnct, CURLOPT_TIMEOUT, 15 );
      $response = json_decode( curl_exec( $instagram_cnct ) ); // получаем и декодируем данные из JSON
      curl_close( $instagram_cnct ); // закрываем соединение

      update_field('access_token', $response['access_token'], 'options');
      update_field('token_timestamp', date('Y-m-d'), 'options');

      $accessToken = $response['access_token'];
    }

    // get media data from token owner account
    $instagram_cnct = curl_init(); // инициализация cURL подключения
    curl_setopt( $instagram_cnct, CURLOPT_URL, "https://graph.instagram.com/me/media?fields=id,media_type,media_url,caption,timestamp,thumbnail_url,permalink,children{fields=id,media_url,thumbnail_url,permalink}&limit=50&access_token=" . $accessToken ); // подключаемся
    curl_setopt( $instagram_cnct, CURLOPT_RETURNTRANSFER, 1 ); // просим вернуть результат
    curl_setopt( $instagram_cnct, CURLOPT_TIMEOUT, 15 );
    $media = json_decode( curl_exec( $instagram_cnct ) ); // получаем и декодируем данные из JSON
    curl_close( $instagram_cnct ); // закрываем соединение

    $instaFeed = array();
    foreach ($media->data as $mediaObj) {
      if (!empty($mediaObj->children)) {
        foreach ($mediaObj->children->data as $children) {
          $instaFeed[$children->id]['img'] = $children->thumbnail_url ?: $children->media_url;
          $instaFeed[$children->id]['link'] = $children->permalink;
        }
      } else {
        $instaFeed[$mediaObj->id]['img'] = $mediaObj->thumbnail_url ?: $mediaObj->media_url;
        $instaFeed[$mediaObj->id]['link'] = $mediaObj->permalink;
      }
    }

    return $instaFeed;
  }

  return false;
}