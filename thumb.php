<?php

    /*
      Como el script se estará ejecutando una cantidad fija de veces por
      un crontab, con esta semilla se busca romper la rigidez y darle un toque
      más humano a las publicaciones.

    */
    $min=1;
    $max=3;
    $ran = mt_rand($min,$max);

    if ($ran > 1) {
      //exit;
    }

    require 'vendor/autoload.php';
    require 'conf/config.php';

    $piece = "";
    $once = 1;
    //cantidad de caracteres máxima a extraer en cada ejecución
    $numchar = 140;
    //
    $num = 1;
    $extracted = 0;
    $publish = "";
    // el archivo origin debe llamarse prueba1.txt o cambiar abajo el nombre
    $origin = fopen("prueba1.txt", "r");
    $temp =fopen("temp.txt","a") or die("Problemas");
    while(!feof($origin)) {
      $line = fgets($origin);
      //extrae los caracteres
      if ($once != 0) {
        $long = strlen($line);
        if ($long  > ($numchar - $extracted))  {
          $xpublish = substr($line,0,($numchar - $extracted));
          $lastspace = strripos($xpublish, " ");
          //$piece = substr($line,($numchar -$extracted),strlen($line));
          $piece = substr($line,$lastspace+1,$long);
          $publish .= substr($line,0,$lastspace);
          $line = $piece;
          $once = 0;
        }
        else {
          $publish = $line;
          $once = 2;
          $extracted = strlen($line);

        }
        $line = $piece;

      }
      //descomentar para ver el texto
      //echo  "&nbsp;" . $line . "<br />";
      if ($once != 2) {fputs($temp,$line);}
    }
    fclose($origin);
    fclose($temp);
    unlink("prueba1.txt");
    rename("temp.txt","prueba1.txt");
    //echo "Frase a publish : <br>";
    //echo "<br><br><br>".$publish;


    /*
      Las credenciales mejor ingresarlas en el archivo conf/config.php
    */

    //  $consumerKey       = "";
    //  $consumerSecret    = "";
    //  $accessToken       = "";
    //  $accessTokenSecret = "";

    $twitter = new Twitter($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);

    try {
      $tweet = $twitter->send($publish); // you can add $imagePath as second argument

    } catch (TwitterException $e) {
      echo 'Error: ' . $e->getMessage();
    }
?>
