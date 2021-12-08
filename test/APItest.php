<?php

class APItest extends \PHPUnit\Framework\TestCase{
    //CASO DE PRUEBA EXITOSO
    public function test_obtener_farmacia_mas_cercana(){
      $cliente = new GuzzleHttp\Client();

      $res = $cliente->request('GET', 'http://localhost/farmacia/api/farmacias/?longitud=-58.3722299&latitud=-34.7370397');  
      $data = json_decode($res->getBody(), true);
      //LOS DATOS DE GEO CODING SON OBTENIDOS DESDE "opencagedata.com" YA QUE ESTE DECODIFICA LA DIRECCION EN LAT, Y LGT (Google Maps arroja distintas coordenadas)
      print_r($data);
      $this->assertEquals('1', $data[0]["id"]);
      $this->assertEquals('Farmacia yachelini', $data[0]["nombre"]);
      $this->assertEquals('Matanza 3259 Piso Pb 1825 Monte Chingolo Buenos Aires ', $data[0]["direccion"]);  
    } 

    //*  PRUEBA QUE FALLA AL REPETIR EL MISMO SET DE DATOS, CONFLICTO CON LA DIRECCION, NO PUEDEN EXISTIR DOS DIRECCIONES IGUALES */
    public function test_crear_farmacia(){
      $cliente = new GuzzleHttp\Client();

      $response = $cliente->request('POST', 'http://localhost/farmacia/api/farmacias/', [
        'json' => [
            'id'=> '',
            'nombre' => 'farmacia',
            'direccion' => 'Matanza 3259 Piso Pb 1825 Monte Chingolo Buenos Aires ',
            'latitud' => -20.000000,
            'longitud' => -20.000000
        ]
      ]);

      $data = json_decode($response->getBody(), true);
      $this->assertEquals(200,$data['code']);
    }

    //** PRUEBA QUE LOS DATOS LLEGUEN CORRECTAMENTE Y NO SE REPITA LA DIRECCION DEL SET DE DATOS CON UNO YA EXISTENTE EN LA DB */
    public function test_crear_farmacia_correctamente(){
      $cliente = new GuzzleHttp\Client();

      $direccion = rand(1,9999);
      $direccion = "Direccion: ".(string)$direccion;

      $response = $cliente->request('POST', 'http://localhost/farmacia/api/farmacias/', [
        'json' => [
            'id'=> '',
            'nombre' => 'farmacia',
            'direccion' => $direccion,
            'latitud' => -20.000000,
            'longitud' => -20.000000
          ]
      ]);

    $data = json_decode($response->getBody(), true);
    $this->assertEquals(200, $data['code']);

    }
}