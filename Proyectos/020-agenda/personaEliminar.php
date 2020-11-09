<?php
require_once "_varios.php";

$pdo = obtenerPdoConexionBD();

$id = (int)$_REQUEST["id"];

$sql = "DELETE FROM persona WHERE id=?";

$sentencia = $pdo->prepare($sql);
$sql_con_exito = $sentencia->execute([$id]);

$una_fila_afectada = ($sentencia->rowCount() == 1);
$ninguna_fila_afectada = ($sentencia->rowCount() == 0);

$correcto = ($sql_con_exito && $una_fila_afectada);

$no_existia = ($sql_con_exito && $ninguna_fila_afectada);
?>

<html>

<head>
    <meta charset="UTF-8">
</head>



<body>