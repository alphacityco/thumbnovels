<?php
  require 'vendor/autoload.php';
  require 'conf/config.php';
  //include ('vendor/dg/twitter-php/src/twitter.class.php');

  // ENTER HERE YOUR CREDENTIALS (see readme.txt)
  /*
  $consumerKey       = "";
  $consumerSecret    = "";
  $accessToken       = "";
  $accessTokenSecret = "";
  */
  $twitter = new Twitter($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);
  try {
    $tweet = $twitter->send('Prueba con vendor-composer 2 salchicha'); // you can add $imagePath as second argument
  } catch (TwitterException $e) {
    echo 'Error: ' . $e->getMessage();
  }
?>
