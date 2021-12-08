<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="css/style.css">
  <title>Document</title>
  </head>
  <body>
    <section class="form-login">
      <h5>Formulario Login</h5>
      <input class="controls" type="text" id="usuario" name="usuario" value="" placeholder="Usuario">
      <input class="controls" type="password"  id="clave" name="clave" value="" placeholder="Contraseña">
      <input class="buttons" type="button" onClick="login()" name="" value="Ingresar">
      <div id="error"></div>
      <p><a href="crear.php">Crear Usuario</a></p>
    </section>

    <script src="js/controlador-usuarios.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

  </body>
</html>