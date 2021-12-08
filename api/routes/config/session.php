<?php
//** VALIDA QUE LA LLAVE UNICA DEL USUARIO PARA PODER ACCEDER, SI NO TIENE UNA LLAVE UNICA, SU ACCESO ES DENEGADO
session_start();
  if(!isset($_SESSION["token"]))
  header("Location:index.php");

  if(!isset($_COOKIE["token"]))
  header("Location: index.php");

  if($_SESSION["token"] !=  $_COOKIE["token"])
  header("Location: index.php");
