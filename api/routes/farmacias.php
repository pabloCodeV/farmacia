<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app =new \Slim\App;

/******* GET -> DEVUELVE UN LISTADO DE FARMACIAS O UNA DEPENDIENDO DE SI SE LE ESPECIFICA UN ID ***************/
$app->get('/farmacias/[{id}/]', function($request, $response, array $args){
  $db =  new db();
  $db = $db->conecctionDB();
  $get = $request->getQueryParams();
  $where = " WHERE 1=1 ";

  
    //FILTRO POR ID
    if(!empty($args['id'])){
      $where .= " AND id = :id "; 
      $id = $args['id'];
    }

    //FILTRO POR LATITUD/LONGITUD
    if(!empty($get['latitud']) && !empty($get['longitud'])){
      $longitud = $get['longitud'];
      $latitud = $get['latitud'];
      $sql = $db->prepare("SELECT id, nombre, direccion, latitud, longitud,(3956 * 2 * ASIN(SQRT( POWER(SIN(( $latitud - latitud) *  pi()/180 / 2), 2) +COS( $latitud * pi()/180) * COS(latitud * pi()/180) * POWER(SIN(( $longitud - longitud) * pi()/180 / 2), 2) ))) AS distance FROM farmacias $where HAVING  distance <= 10 
      ORDER BY distance LIMIT 1");
    }else{
      $sql = $db->prepare("SELECT id, nombre, direccion, latitud, longitud FROM farmacias $where");
    }

    if(!empty($args['id'])){
      $sql->bindParam(':id', $id , PDO::PARAM_INT);
    }

  try{
    $sql->execute();
    $resultados = $sql->fetchAll(PDO::FETCH_OBJ);
    $db = null;

    $response->getBody()->write(json_encode($resultados));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(200);

  }catch(PDOException $e){
      $error = array(
      "message"=>$e->getMessage()
      );
      $response->getBody()->write(json_encode($error));
        return $response
            ->withHeader('content-type', 'application/json')
            ->whitStatus(500);
        }
});

/************ POST -> CARGA UNA NUEVA FARMACIA O EDITA UNA FARMACIA DE UN ID EN ESPECIFICO ************/
$app->post('/farmacias/[{id}/]', function( $request, $response, array $args){
  $db =  new db();
  $db = $db->conecctionDB();
  $inputData = $request->getParsedBody();       

  //VALIDA QUE LOS DATOS NO LLEGUEN CORRUPTOS
  if(is_null($inputData)){                      
    return $response
          ->withStatus(400)
          ->withJson(array(
                    'code' => 400,
                    'msj' => "Bad Request"
                    ));
  }

  //SE COMPRUEBA SI RECIBE ID COMO ARGUMENTO EN LA URL
  if(!empty($args['id'])){
    $data['id'] = $args['id'];  
  }

  //SET DE DATOS RECIBIDOS
  $data['nombre'] = $inputData['nombre'];
  $data['direccion'] = $inputData['direccion'];   
  $data['latitud'] = $inputData['latitud'];
  $data['longitud'] = $inputData['longitud'];

  $res  = $db->query('SELECT * FROM farmacias');
  $res= $res->fetchAll();

  foreach($res as $key  => $value ){
    $direccion = $res[$key]["direccion"];

    //SE COMPRUEBA QUE EL ID PASADO COMO ARGUMENTO SEA EXISTENTE
    if(!empty($data['id']) ){
      $exist = $db->query("SELECT COUNT(*) 
                          AS counter 
                          FROM farmacias 
                          WHERE id = ".$data['id']."  LIMIT 1");
      $exist = $exist->fetchAll();

      //EN CASO DE BUSCAR UNA FARMACIA CON UN ID INEXISTENTE
      if($exist[0]["counter"]==0){
              return $response->withStatus(500)
                              ->withJson(array(
                                              "code" => 500,
                                              "msj" => "No se pudo encontrar la Farmacia"
                                          ));
      }   

      $sql = "UPDATE farmacias 
                SET   nombre = :nombre,
                      direccion = :direccion,
                      latitud = :latitud,
                      longitud = :longitud
                WHERE id = ".$data['id'];
    }
  }
    
    //SI EL ARGUMENTO ID ES VACIO, SE CREA
    if(empty($data["id"])){                                                     
      $sql = "INSERT INTO farmacias (nombre, direccion, latitud, longitud) 
                  VALUES           (:nombre, :direccion, :latitud, :longitud)";

      //COMPRUEBA SI LA DIRECCION EXISTE EN LA DB
      if($direccion == $data['direccion'] ){
        return $response
          ->withStatus(409)
          ->withJson(array(
                    'code' => 409,
                    'msj' => "conflict"
                    ));
      }
    }

  try{
    $resultado = $db->prepare($sql);

    //SET DE DATOS LISTOS PARA SER INSERTADOS EN LA QUERY SQL
    $resultado->bindParam(':nombre', $data['nombre'] );
    $resultado->bindParam(':direccion', $data['direccion']);
    $resultado->bindParam(':latitud', $data['latitud']);
    $resultado->bindParam(':longitud', $data['longitud']);

    $resultado->execute();

    if($resultado){
      return $response
      ->withStatus(200)
      ->withJson(array(
                'code' => 200,
                'msj' => "OK"
                ));
    }

    $resultado = null;
    $db = null;
  }catch(PDOException $e){
    echo '{"error" : {"text":'.$e->getMessage().'}';
  }

});

/************************ DELETE ************************/
$app->delete('/farmacias/[{id}/]', function( $request, $response, array $args){
  $db =  new db();
  $db = $db->conecctionDB();
  $id_farmacia = $request->getAttribute('id');

  //BORRA EL ELEMENTO SELECCIONADO SEGUN SU ID
  $sql = "DELETE FROM farmacias WHERE id = $id_farmacia";

  try{
    $resultado = $db->prepare($sql);
    $resultado->execute();

    if ($resultado->rowCount() > 0) {
      return $response
        ->withStatus(200)
        ->withJson(array(
                  'code' => 200,
                  'msj' => "Ok"
                  ));
    }else {
      return $response
        ->withStatus(500)
        ->withJson(array(
                  'code' => 500,
                  'msj' => "No existe en la DB"
                  ));
    }

    $resultado = null;
    $db = null;
  }catch(PDOException $e){
    echo '{"error" : {"text":'.$e->getMessage().'}';
  }
});