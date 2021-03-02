<?php

require_once "_com/Dao.php";
require_once "_com/Varios.php";


	// Se recogen los datos del formulario de la request.
	$id = (int)$_REQUEST["id"];
	$nombre = $_REQUEST["nombre"];
	$apellidos = $_REQUEST["apellidos"];
    $categoriaId = (int)$_REQUEST["categoriaId"];
    $estrella = isset($_REQUEST["estrella"]);
    $resultado=false;
    $datosNoModificados=false;

	// Si id es -1 quieren INSERTAR una nueva entrada ($nueva_entrada tomará true).
	// Sin embargo, si id NO es -1 quieren ACTUALIZAR la ficha de una persona existente
	// (y $nueva_entrada tomar false).
	$nuevaEntrada = ($id == -1);
	
	if ($nuevaEntrada) {
		/*Quieren CREAR una nueva entrada, así que es un INSERT.
 		$sql = "INSERT INTO Persona (nombre, apellidos, telefono, estrella, categoriaId) VALUES (?, ?, ?, ?, ?)";
        $parametros = [$nombre, $apellidos, $telefono, $estrella?1:0, $categoriaId];*/

        $resultado=dao::personaCrear($nombre,$apellidos,$categoriaId,$estrella,$id);
        redireccionar("personaListado.php");
	} else {
		/* Quieren MODIFICAR una persona existente y es un UPDATE.
 		$sql = "UPDATE Persona SET nombre=?, apellidos=?, telefono=?, estrella=?, categoriaId=? WHERE id=?";
        $parametros = [$nombre, $apellidos, $telefono, $estrella?1:0, $categoriaId, $id];*/
        $datosNoModificados = DAO::personaModificar($nombre,$apellidos,$categoriaId,$estrella);
        redireccionar("personaListado.php");
 	}




    // Esta llamada devuelve true o false según si la ejecución de la sentencia ha ido bien o mal.

?>

