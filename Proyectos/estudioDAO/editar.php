<?php

include_once "com/DAO.php";
//include_once "conexion.php";
$id=$_REQUEST['id'];
$color=$_REQUEST['color'];
$descripcion=$_REQUEST['descripcion'];

//echo $id;
//echo $color;
//echo  $descripcion;

$resultado= DAO::editarColor($color,$descripcion,$id);
/*
$sql_editar = 'UPDATE colores SET color=?,descripcion=? WHERE id=?';

$_sentencia_editar = $pdo-> prepare($sql_editar);
//aqui le decimos array( de nuestras interrogaciones)
$_sentencia_editar->execute(array($color,$descripcion,$id));*/



if($resultado)
    redireccionar("index.php");
else
    redireccionar("index.php");
?>




