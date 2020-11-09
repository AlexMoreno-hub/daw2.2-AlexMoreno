<?php
require_once "_varios.php";

$pdo = obtenerPdoConexionBD();

$id = (int)$_REQUEST["id"];

$nueva_entrada = ($id == -1);

if ($nueva_entrada) {
    $persona_nombre = "<introduzca nombre>";
    $persona_telefono = "<introduzca telefono>";
    $personaCategoriaId = "<introduzca el id de su categoria>";
} else {
    $sql = "SELECT id, nombre, telefono, categoria_id FROM persona WHERE id=?";

    $select = $pdo->prepare($sql);
    $select->execute([$id]);
    $rs = $select->fetchAll();

    $persona_nombre = $rs[0]["nombre"];
    $persona_telefono = $rs[0]["telefono"];
    $personaCategoriaId = $rs[0]["categoria_id"];
}
?>



<html>

<head>