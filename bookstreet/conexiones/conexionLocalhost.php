<?php
$servidor = "localhost";
$baseDatos = "dbLibreria";
$usuarioBd = "root";
$passwordBd = "";

// Creamos la conexion
$conexionLocalhost = mysql_connect($servidor, $usuarioBd, $passwordBd) or trigger_error(mysql_error(), E_USER_ERROR);

// Definimos el cotejamiento para la conexion (igual al cotejamiento de la BD)
mysql_query("SET NAMES 'utf8'");

// Seleccionamos la base de datos por defecto para el proyecto
mysql_select_db($baseDatos, $conexionLocalhost);
?>