<?php

include_once "conexion.php";


$id=$_REQUEST['id'];

$sql_eliminar= 'DELETE FROM colores WHERE id=?';
$sentencia_eliminar= $pdo->prepare($sql_eliminar);
$sentencia_eliminar->execute(array($id));

header('location:index.php');