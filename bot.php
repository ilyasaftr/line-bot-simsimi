<?php
/*
copyright @ ngawur.com
Modified by Afzal
And Modified by Afzal - zFz ( Afzal )
2018
*/
require_once('./line_class.php');
$channelAccessToken = 'xq1ZicEYD8t+gkFSePswCnb2EVf/bo6fj4tB3VySMuWtZRUp6prf9TOwAYYp4tNDlACdpglyR0Yx3WCeCWplXWbyLYqi/jlyNvpFJ1+npW5c9q1EIii4iQciPDkfPIxhquEHP5OSYL6dLxEU6T3fowdB04t89/1O/w1cDnyilFU='; //Your Channel Access Token
$channelSecret = '068ed74c96a8b5bc4c066fce61209e7c';//Your Channel Secret
$client = new LINEBotTiny($channelAccessToken, $channelSecret);
$userId  = $client->parseEvents()[0]['source']['userId'];
$replyToken = $client->parseEvents()[0]['replyToken'];
$message  = $client->parseEvents()[0]['message'];
$profil = $client->profil($userId);
$pesan_datang = $message['text'];
if($message['type']=='sticker')
{ 
 $balas = array(
       'UserID' => $profil->userId, 
                                                        'replyToken' => $replyToken,       
       'messages' => array(
        array(
          'type' => 'text',         
          'text' => 'Terima Kasih Stikernya.'          
         
         )
       )
      );
      
}
else
$pesan=str_replace(" ", "%20", $pesan_datang);
$key = 'df9b02ef-6b8a-4337-a383-80af09b0c6f0'; //API SimSimi
$url = 'http://sandbox.api.simsimi.com/request.p?key='.$key.'&lc=id&ft=1.0&text='.$pesan;
$json_data = file_get_contents($url);
$url=json_decode($json_data,1);
$diterima = $url['response'];
if($message['type']=='text')
{
if($url['result'] == 404)
 {
  $balas = array(
       'UserID' => $profil->userId, 
                                                        'replyToken' => $replyToken,             
       'messages' => array(
        array(
          'type' => 'text',     
          'text' => 'Mohon Gunakan Bahasa Indonesia Yang Benar :D.'
         )
       )
      );
    
 }
else
if($url['result'] != 100)
 {
  
  
  $balas = array(
       'UserID' => $profil->userId,
                                                        'replyToken' => $replyToken,              
       'messages' => array(
        array(
          'type' => 'text',     
          'text' => 'Maaf '.$profil->displayName.' Server Kami Sedang Sibuk Sekarang.'
         )
       )
      );
    
 }
 else{
  $balas = array(
       'UserID' => $profil->userId,
                                                        'replyToken' => $replyToken,              
       'messages' => array(
        array(
          'type' => 'text',     
          'text' => ''.$diterima.''
         )
       )
      );
      
 }
}
 
$result =  json_encode($balas);
file_put_contents('./reply.json',$result);
$client->replyMessage($balas);
