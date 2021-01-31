<?php
	require_once "_com/Varios.php";

	$conexionBD = obtenerPdoConexionBD();

	// Se recoge el parámetro "id" de la request.
	$id = (int)$_REQUEST["id"];

	$sql = "DELETE FROM Categoria WHERE id=?";

    $sentencia = $conexionBD->prepare($sql);
    //Esta llamada devuelve true o false según si la ejecución de la sentencia ha ido bien o mal.
    $sqlConExito = $sentencia->execute([$id]); // Se añade el parámetro a la consulta preparada.


    $correctoNormal = ($sqlConExito && $sentencia->rowCount() == 1);


 	$noExistia = ($sqlConExito && $sentencia->rowCount() == 0);


?>



<html>

<head>
	<meta charset='UTF-8'>
</head>



<body>

<?php if ($correctoNormal) { ?>

	<h1>Eliminación completada</h1>
	<p>Se ha eliminado correctamente la categoría.</p>

<?php } else if ($noExistia) { ?>

	<h1>Eliminación no realizada</h1>
	<p>No existe la categoría que se pretende eliminar (quizá la eliminaron en paraleo o, ¿ha manipulado Vd. el parámetro id?).</p>

<?php } else { ?>

	<h1>Error en la eliminación</h1>
	<p>No se ha podido eliminar la categoría.</p>

<?php } ?>

<a href='CategoriaListado.php'>Volver al listado de categorías.</a>

</body>

</html>