<?php
include '../api/routes/config/session.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
  <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/>
  <link rel="stylesheet" href="css/style.css">
  <title>Farmacias</title>
</head>
  <body>
    <a href="logout.php" class="btn btn-danger logout">cerrar sesion</a>
    <div class="container mt-4 shadow-lgp-3 mb-5  bg-body rounded">
    <button id="btnCrear" type="button" class="btn btn-primary" data-bs-toggle="modal"  data-bs-target="#modalAtributo">Crear</button>

      <table id="tablaAtributos" class="table mt-2 table-bordered table-striped">
        <thead>
          <tr class="text-center">
            <th>Id</th>
            <th>Nombre</th>
            <th>Direccion</th>
            <th>Latitud</th>
            <th>longitud</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>

    <div id="modalAtributo" class="modal fade" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="exampleModalLabel">Articulo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form>
          <div class="mb-3">
          <label for="nombre" class="col-form-label">Nombre:</label>
            <input type="text" class="form-control" id="nombre">
          </div>
          <div class="mb-3">
            <label for="direccion" class="col-form-label">Direccion:</label>
            <input type="text" class="form-control" id="direccion">
          </div>
          <div class="mb-3">
            <label for="latitud" class="col-form-label">Latitud:</label>
            <input type="text" class="form-control" id="latitud">
          </div>
          <div class="mb-3">
            <label for="longitud" class="col-form-label">Longitud:</label>
            <input type="text" class="form-control" id="longitud">
          </div>      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Guardar</button>
      </div>
    </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
<script src="js/controlador-farmacias.js"></script>
</body>
</html>