<?php
class Nuevo_Push{
  public $titulo_esp = "";
  public $titulo_ing = "";
  public $mensaje_esp = "";
  public $mensaje_ing = "";
  public $url_personalizado = "";

  function __construct()
  {
  }

  function enviar(){
    $client = new \GuzzleHttp\Client();
    $APP_ID = $_ENV['ONESIGNAL_APP_ID'];
    $API_KEY = $_ENV['ONESIGNAL_API_KEY'];

    if($this->url_personalizado == ""){
      $url = $_ENV['HOMEDIR'];
    }elseif($this->url_personalizado != ""){
      $url = $this->url_personalizado;
    }

    $array = [
      'app_id' => $APP_ID,
      'included_segments' => ['Subscribed Users'],
      'contents' => [
          'en' => $this->mensaje_ing,
          'es' => $this->mensaje_esp
      ],
      'headings' => [
          'en' => $this->titulo_ing,
          'es' => $this->titulo_esp
      ],
      'url' => $url
    ];
  
    $contenido_body = json_encode($array, JSON_THROW_ON_ERROR);
    $response = $client->request('POST', 'https://onesignal.com/api/v1/notifications', [
      'body' => $contenido_body,
      'headers' => [
        'Authorization' => "Basic $API_KEY",
        'accept' => 'application/json',
        'content-type' => 'application/json',
      ],
    ]);
            
    $statusCode = $response->getStatusCode();
    if ($statusCode === 200) {
      $this->limpiar();
      return true;
    } else {
      $this->limpiar();
      return false;
    }
  }
  
  function limpiar(){
    $this->titulo_esp = "";
    $this->titulo_ing = "";
    $this->mensaje_esp = "";
    $this->mensaje_ing = "";
    $this->url_personalizado = "";
  }
  
  function cerrar(){
    $this->limpiar();
    return NULL;
  }
}
?>