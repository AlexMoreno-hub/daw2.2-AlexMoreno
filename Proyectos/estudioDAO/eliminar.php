<?php

require_once 'com/DAO.php';


$id=$_REQUEST['id'];
/*
$sql_eliminar= 'DELETE FROM colores WHERE id=?';
$sentencia_eliminar= $pdo->prepare($sql_eliminar);
$sentencia_eliminar->execute(array($id));

header('location:index.php');*/

$resultado = DAO::colorEliminar($id);

/*si obtenemos borrar*/
if($resultado)
    redireccionar("index.php");
else
    redireccionar("index.php");
?>
