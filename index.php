<?php

// new api
$accessToken = 'token'; // получаем токен
$tokenDate = 'date'; // получаем дату создания
$tokenTimestamp = strtotime($tokenDate);
$curTimestamp = time();
$dayDiff = ($curTimestamp - $tokenTimestamp) / 86400;

if (!empty($accessToken)) {

  // Refresh a long-lived Instagram User Access Token that is at least 24 hours old but has not expired. Refreshed tokens are valid for 60 days from the date at which they are refreshed.
  if ($dayDiff > 50) {
    $url = "https://graph.instagram.com/refresh_access_token?grant_type=ig_refresh_token&access_token=" . $accessToken;
    curl_setopt($instagram_cnct, CURLOPT_URL, $url);
    curl_setopt($instagram_cnct, CURLOPT_RETURNTRANSFER, 1);
    $response = json_decode(curl_exec($instagram_cnct ));
    curl_close($instagram_cnct);

    // обновляем токен и дату его создания в базе

    $accessToken = $response->access_token; // обновленный токен
  }

  // Get media data from token owner account
  $url = "https://graph.instagram.com/me/media?fields=id,media_type,media_url,caption,timestamp,thumbnail_url,permalink,children{fields=id,media_url,thumbnail_url,permalink}&limit=50&access_token=" . $accessToken;
  $instagram_cnct = curl_init();
  curl_setopt($instagram_cnct, CURLOPT_URL, $url);
  curl_setopt($instagram_cnct, CURLOPT_RETURNTRANSFER, 1);
  $media = json_decode(curl_exec($instagram_cnct));
  curl_close($instagram_cnct);

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
}
