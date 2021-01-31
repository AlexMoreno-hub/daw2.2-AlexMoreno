<?php

 require_once "_com/_dao.php";

// TODO ...$_REQUEST["..."]...
 $identificador = isset($REQUEST["identificador"]);
$contrasenna = isset($REQUEST["contrasenna"]);

// TODO Intentar crear (añadir funciones en Varios.php para crear y tal).
//
// TODO Y redirigir a donde sea.

$arrayUsuario = crearUsuario($identificador, $contrasenna);

// TODO ¿Excepciones?

if ($arrayUsuario) {

} else {

}