
<?php
// REQUERIMIENTOS
require_once "_com/_dao.php";
// OBTENEMOS LOS DATOS DEL FORMULARIO DE REGISTRO
$identificador = $_REQUEST["identificador"];
$contrasenna = $_REQUEST["contrasenna"];
$nombre = $_REQUEST["nombre"];
$apellidos = $_REQUEST["apellidos"];

// CREAMOS EL USUARIO
$arrayUsuario = DAO::crearUsuario($identificador, $contrasenna, $nombre, $apellidos);

if ($arrayUsuario) {
    // SI EXISTE EL USUARIO NOS ENVÍA AL LOGIN
    redireccionar("SesionInicioFormulario.php");
} else {
    // EN CASO CONTRARIO DEVUELVE ERROR
    echo "FALTAN DATOS, no se ha creado";
}