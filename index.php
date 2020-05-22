<?php

// new api
$accessToken = 'token'; // получаем токен
$tokenDate = 'date'; // получаем дату создания
$tokenTimestamp = strtotime($tokenDate);
$curTimestamp = time();
$dayDiff = ($curTimestamp - $tokenTimestamp) / 86400;

if (!empty($accessToken)) {
  if ($dayDiff > 50) {
    $url = "https://graph.instagram.com/refresh_access_token?grant_type=ig_refresh_token&access_token=" . $accessToken;
    curl_setopt($instagramCnct, CURLOPT_URL, $url);
    curl_setopt($instagramCnct, CURLOPT_RETURNTRANSFER, 1);
    $response = json_decode(curl_exec($instagramCnct));
    curl_close($instagramCnct);

    // обновляем токен и дату его создания в базе

    $accessToken = $response->access_token; // обновленный токен
  }

  $url = "https://graph.instagram.com/me/media?fields=id,media_type,media_url,caption,timestamp,thumbnail_url,permalink,children{fields=id,media_url,thumbnail_url,permalink}&limit=50&access_token=" . $accessToken;
  $instagramCnct = curl_init();
  curl_setopt($instagramCnct, CURLOPT_URL, $url);
  curl_setopt($instagramCnct, CURLOPT_RETURNTRANSFER, 1);
  $media = json_decode(curl_exec($instagramCnct));
  curl_close($instagramCnct);

  $instaFeed = array();
  foreach ($media->data as $mediaObj) {
    if (!empty($mediaObj->children)) {
      foreach ($mediaObj->children->data as $children) {
        $instaFeed[$children->id]['src'] = $children->media_url;
        $instaFeed[$children->id]['preview'] = $children->thumbnail_url;
        $instaFeed[$children->id]['link'] = $children->permalink;
        $instaFeed[$children->id]['media_type'] = $children->media_type;
      }
    } else {
      $instaFeed[$mediaObj->id]['src'] = $mediaObj->media_url;
      $instaFeed[$mediaObj->id]['preview'] = $mediaObj->thumbnail_url;
      $instaFeed[$mediaObj->id]['link'] = $mediaObj->permalink;
      $instaFeed[$mediaObj->id]['media_type'] = $mediaObj->media_type;
    }
  }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
  <style>
    .insta_post {
      max-width: 300px;
    }
  </style>
</head>
<body>

  <?php foreach($instaFeed as $key => $post): ?>

      <?php if ($post['media_type'] === 'VIDEO'): ?>
      <video autoplay muted loop controls class="insta_post">
       <source src="<?php echo $post['src']; ?>" type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"'>
        Видео не поддерживается
        <a href="<?php echo $post['link']; ?>"><img src="<?php echo $post['preview']; ?>" class="insta_post"> </a>
      </video>
      <?php else: ?>
      <a href="<?php echo $post['link']; ?>"><img src="<?php echo $post['src']; ?>" class="insta_post"> </a>
      <?php endif; ?>
   
  <?php endforeach; ?>

</body>
</html>