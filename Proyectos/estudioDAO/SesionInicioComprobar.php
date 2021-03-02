<?php
// REQUIRIMIENTOS
require_once "com/DAO.php";

// OBTENEMOS AL USUARIO
$arrayUsuario = DAO::obtenerUsuarioPorContrasenna($_REQUEST["identificador"], $_REQUEST["contrasenna"]);

// SI EXISTE EL USUARIO
if ($arrayUsuario) {
    // CREA UNA SESION
    DAO::establecerSesionRam($arrayUsuario);
    if (isset($_REQUEST["recordar"])) {
        // SI LE DAMOS AL CHECKBOX. CREA LA COOKIE
        DAO::establecerSesionCookie($arrayUsuario);
    }
    // ENVIAMOS AL MURO DE GLOBAL
    redireccionar("index.php");
} else {
    // SI NO EXISTE EL USUARIO DEVOLVEMOS UN ERROR
    redireccionar("SesionInicioFormulario.php?datosErroneos");
}