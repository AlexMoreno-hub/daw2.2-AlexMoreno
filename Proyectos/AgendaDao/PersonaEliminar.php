<?php


require_once "_com/dao.php";
require_once "_com/Varios.php";


$id = (int)$_REQUEST["id"];

$resultado = DAO::personaEliminar($id);

if ($resultado)
    redireccionar("personaListado.php?eliminacionCorrecta");
else
    redireccionar("personaListado.php?eliminacionErronea");


?>


