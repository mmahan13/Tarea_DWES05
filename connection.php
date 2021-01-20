<?php 

//Indicamos codificacion UTf-8
$opciones = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
//Conexión BDD dwes
$dwes = new PDO('mysql:host=localhost;dbname=dwes','root', '', $opciones);


?>