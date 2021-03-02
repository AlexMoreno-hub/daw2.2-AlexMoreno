<?php

require_once "_com/dao.php";
require_once "_com/Varios.php";

	// Se recogen los datos del formulario de la request.
	$id = (int)$_REQUEST["id"];
	$nombre = $_REQUEST["nombre"];
    $nuevaEntrada = ($id == -1);
    $resultado=false;
    $datosNoModificados=false;

	// Si id es -1 quieren CREAR una nueva entrada ($nueva_entrada tomará true).
	// Sin embargo, si id NO es -1 quieren VER la ficha de una categoría existente
	// (y $nueva_entrada tomará false).
	$nuevaEntrada = ($id == -1);
	
	if ($nuevaEntrada) {
		/*Quieren CREAR una nueva entrada, así que es un INSERT.
 		$sql = "INSERT INTO Categoria (nombre) VALUES (?)";
 		$parametros = [$nombre];*/
        $resultado=dao::categoriaCrear($nombre);
        redireccionar("categoriaListado.php");

	} else {
		/* Quieren MODIFICAR una categoría existente y es un UPDATE.
 		$sql = "UPDATE Categoria SET nombre=? WHERE id=?";
        $parametros = [$nombre, $id];*/

    $datosNoModificados = DAO::categoriaModificar($id,$nombre);
    redireccionar("categoriaListado.php");
 	}
 	




 	// INTERFAZ:
    // $nuevaEntrada
    // $correcto
    // $datosNoModificados
?>

