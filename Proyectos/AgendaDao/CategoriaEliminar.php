<?php
require_once "_com/DAO.php";
require_once "_com/Varios.php";

// Se recoge el parámetro "id" de la request.
$id = (int)$_REQUEST["id"];

$resultado = DAO::categoriaEliminar($id);

/*si obtenemos borrar*/
if ($resultado)
    redireccionar("categoriaListado.php?eliminacionCorrecta");
else
    redireccionar("categoriaListado.php?eliminacionErronea");



