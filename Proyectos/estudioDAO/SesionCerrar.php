<?php
// REQUERIMIENTOS
require_once "com/DAO.php";
// ELIMINAMOS LA SESION Y LA COOKIE Y REDIRECCIONAMOS AL INICIO
DAO::destruirSesionRamYCookie();
redireccionar("index.php");