<?php
/********* GET -> DEVUELVE UN LISTADO DE USUARIOS O UNO SI SE LE ESPECIFICA EL ID ************************/
$app->get('/usuarios/[{id}/]', function($request, $response, array $args){
  $db =  new db();                        
  $db = $db->conecctionDB();
  $where = " WHERE 1=1 ";

   //FILTRO POR ID
  if(!empty($args['id'])){
    $where .= " AND id=:id";
    $id = $args['id'] ;
  }

  $sql = $db->prepare("SELECT id, nombre, direccion FROM usuarios $where ");
  
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

/*********** POST -> SE CARGA UN NUEVO USUARIO **********************/
$app->post('/usuarios/[{id}/]', function( $request, $response, array $args){
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

  if(!empty($args['id'])){
    $data['id'] = $args['id'];  
  }

  $data['nombre'] = $inputData['nombre'];
  $data['clave'] = $inputData['clave'];
  $data['direccion'] = 1;

  $res  = $db->query('SELECT * FROM usuarios');
  $res= $res->fetchAll();

  foreach($res as $key  => $value ){

    //COMPRUEBA QUE EL USUARIO EXISTA
    if(!empty($data['id']) ){
      $exist = $db->query("SELECT COUNT(*) AS counter FROM usuarios WHERE id = ".$data['id']."  LIMIT 1");
      $exist = $exist->fetchAll();

      if($exist[0]["counter"]==0){
              return $response->withStatus(409)
                              ->withJson(array(
                                              "code" => 409,
                                              "msj" => "Customer Not Found"
                                          ));
      }   

      $sql = "UPDATE usuarios 
                SET   nombre = :nombre,
                      direccion = :direccion,
                      clave = :clave
                WHERE id = ".$data['id'];
    }
  }
    
    //SI EL ARGUMENTO ID ES VACIO, SE CREA
    if(empty($data["id"])){                                                     
      $sql = "INSERT INTO usuarios (nombre, direccion, clave) 
                  VALUES           (:nombre, :direccion, clave)";
    }

  try{
    $resultado = $db->prepare($sql);

    $resultado->bindParam(':nombre', $data['nombre'] );
    $resultado->bindParam(':direccion', $data['direccion']);
    $resultado->bindParam(':clave', $data['clave']);

    $resultado->execute();

    if($resultado){
      return $response
      ->withStatus(409)
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

/********* POST LOGIN -> SE UTILIZA PARA EL INGRESO A LA PAGINA ***********/
$app->post('/customers_login/', function ($request, $response) {
  session_start();
  $db =  new db();                        
  $db = $db->conecctionDB();
  $inputData = $request->getParsedBody();

  //VALIDA QUE LOS DATOS DE ENTRADA NO ESTEN CORRUPTOS
  if(is_null($inputData)){    
    return $response
      ->withStatus(400)
      ->withJson(array(
                        'code' => 400,
                        'msj' => "Bad Request"
    ));
  }
  $data['nombre'] = $inputData['nombre'];
  $data['clave'] = $inputData['clave'];

  //VERIFICAMOS QUE EL USUARIO Y CONTRASEÑA EXISTAN EN LA BASE DE DATOS
  $exist = $db->prepare("SELECT * FROM usuarios WHERE nombre = :nombre AND clave = :clave");
  $exist->bindParam(':nombre', $data['nombre'] , PDO::PARAM_STR);
  $exist->bindParam(':clave', $data['clave'] , PDO::PARAM_STR);
  $exist->execute();
  $resultados = $exist->fetchAll(PDO::FETCH_OBJ);

  if(empty($resultados)){
    return $response
    ->withStatus(401)
    ->withJson(array(
              'code' => 401,
              'msj' => "Bad Request",
              
    ));
  }

   //LLAVE UNICA DE INGRESO DE SESION PHP
  $token = sha1(uniqid(rand(),true));
  $_SESSION["token"]  = $token;

  if(!empty($resultados['nombre'])&& !empty($resultados['clave'])) $resultados = $resultados[0]; 
    if(!empty($resultados)){
      //COOKIE DE INGRESO CON TIEMPO DE EXPIRACION
      setcookie("token",$token,time()+(60*60*24*31),"/");
    }else{
      //EN CASO DE FALLO,LA COOKIE SE CREA CON UN TIEMPO EXPIRADO (se destruye)
      setcookie("token",$token,time()-1,"/");
    }
    
  return $response->withStatus(200)
                  ->withJson(array(
                            'code' => 200,
                            'data' => $resultados
  ));

});
