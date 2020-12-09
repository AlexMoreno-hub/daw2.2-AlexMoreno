<?php
require_once "_Varios.php";
// TODO ...$_REQUEST["..."]...

$_SESSION["identificador"] = $_REQUEST["identificador"];
$_SESSION["contrasenna"] = $_REQUEST["contrasenna"];

$arrayUsuario= obtenerUsuario($_SESSION["identificador"], $_SESSION["contrasenna"]);


// TODO Verificar (usar funciones de _Varios.php) identificador y contrasenna recibidos y redirigir a ContenidoPrivado1 (si OK) o a iniciar sesión (si NO ok).

if ($arrayUsuario) { // HAN venido datos: identificador existía y contraseña era correcta.
    // TODO Llamar a marcarSesionComoIniciada($arrayUsuario) ...
    marcarSesionComoIniciada($arrayUsuario);
    redireccionar("ContenidoPrivado1.php");
    // TODO Redirigir.
}
else {
    // TODO Redirigir.
    redireccionar("SesionInicioMostrarFormulario.php?incorrecto");
}

?>

