<?php
// REQUERIMIENTOS
require_once "_com/_dao.php";
// ELIMINAMOS LA SESION Y LA COOKIE Y REDIRECCIONAMOS AL INICIO
DAO::destruirSesionRamYCookie();
redireccionar("Index.php");