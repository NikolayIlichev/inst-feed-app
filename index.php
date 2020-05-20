<?php

// new api
$accessToken = 'IGQVJVM3NjbHloOW0xWEJQajdjMlR5VkxVWWE0NW16bnZAKS0kwcE5uTlJyczlzUDB6b0NUNlRFVm5xNEFfWjhnelhiS2tsMDljZAzlIcHdKNDY3SFEta3BGd2lPSlF0NkdoTEc1eHVHenl3QnYzbVgyNgZDZD'; // получаем токен
$tokenDate = '19.05.2020'; // получаем дату создания
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
  echo "<pre>";
  print_r($media);
  echo "</pre>";
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
  echo "<pre style='display: none'>";
  print_r($instaFeed);
  echo "</pre>";
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
      <video autoplay="autoplay" muted="muted" class="insta_post">
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