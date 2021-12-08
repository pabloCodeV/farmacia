<?php
//** DATOS DE CONEXION A LA BASE DE DATOS */
class db{
  private $dbHost = "localhost";
  private $dbUser = "root";
  private $dbPass = "";
  private $dbName = "db";

  //** MIENTRAS LOS DATOS SEAN CORRECTOS, SE REALIZA LA CONEXION, DE LO CONTRARIO DEVUELVE UN ERROR */
  public function conecctionDB(){
    $mysqlConnect = "mysql:host=$this->dbHost;dbname=$this->dbName";
    $dbConnecion = new PDO($mysqlConnect, $this->dbUser, $this->dbPass);
    $dbConnecion ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbConnecion;
  }
  
  
}
