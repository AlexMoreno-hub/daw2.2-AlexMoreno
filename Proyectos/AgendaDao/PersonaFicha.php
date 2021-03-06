<?php


require_once "_com/Varios.php";
require_once  "_com/DAO.php";
	
	// Se recoge el parámetro "id" de la request.
	$id = (int)$_REQUEST["id"];

	// Si id es -1 quieren CREAR una nueva entrada ($nueva_entrada tomará true).
	// Sin embargo, si id NO es -1 quieren VER la ficha de una persona existente
	// (y $nueva_entrada tomará false).
	$nuevaEntrada = ($id == -1);
	
	if ($nuevaEntrada) { // Quieren CREAR una nueva entrada, así que no se cargan datos.
		$personaNombre = "<introduzca nombre>";
        $personaApellidos = "<introduzca apellidos>";
		$personaTelefono = "<introduzca teléfono>";
        $personaEstrella = false;
		$personaCategoriaId = 0;
	} else { // Quieren VER la ficha de una persona existente, cuyos datos se cargan.

        $persona = DAO::personaObtenerPorId($id);
        $personaNombre = $persona->getNombre();
        $personaApellidos = $persona->getApellidos();
        $personaEstrella = $persona->getEstrella();
        $personaCategoriaId = $persona->getPersonaCategoriaId();

	}

	
	
	// Con lo siguiente se deja preparado un recordset con todas las categorías.
    $rsCategorias= DAO::personaSelectCategoria();

/*
	$sqlCategorias = "SELECT id, nombre FROM Categoria ORDER BY nombre";

    $select = $conexion->prepare($sqlCategorias);
    $select->execute([]); // Array vacío porque la consulta preparada no requiere parámetros.
    $rsCategorias = $select->fetchAll();*/



    // INTERFAZ:
    // $personaNombre
    // $personaTelefono
    // $personaApellidos
    // $personaEstrella
    // $personaCategoriaId
    // $rsCategorias
?>




<html>

<head>
	<meta charset='UTF-8'>
</head>



<body>

<?php if ($nuevaEntrada) { ?>
	<h1>Nueva ficha de persona</h1>
<?php } else { ?>
	<h1>Ficha de persona</h1>
<?php } ?>

<form method='post' action='PersonaGuardar.php'>

<input type='hidden' name='id' value='<?= $id ?>' />

    <label for='nombre'>Nombre</label>
    <input type='text' name='nombre' value='<?=$personaNombre ?>' />
    <br/>

    <label for='apellidos'> Apellidos</label>
    <input type='text' name='apellidos' value='<?=$personaApellidos ?>' />
    <br/>

    <label for='categoriaId'>Categoría</label>
    <select name='categoriaId'>
        <?php
            foreach ($rsCategorias as $filaCategoria) {
                $categoriaId = (int) $filaCategoria["id"];
                $categoriaNombre = $filaCategoria["nombre"];

                if ($categoriaId == $personaCategoriaId) $seleccion = "selected='true'";
                else                                     $seleccion = "";

                echo "<option value='$categoriaId' $seleccion>$categoriaNombre</option>";

                // Alternativa (peor):
                // if ($categoriaId == $personaCategoriaId) echo "<option value='$categoriaId' selected='true'>$categoriaNombre</option>";
                // else                                     echo "<option value='$categoriaId'                >$categoriaNombre</option>";
            }
        ?>
    </select>
    <br/>

    <label for='estrella'>Estrellado</label>
    <input type='checkbox' name='estrella' <?= $personaEstrella ? "checked" : "" ?> />
    <br/>

    <br/>

<?php if ($nuevaEntrada) { ?>
	<input type='submit' name='crear' value='Crear persona' />
<?php } else { ?>
	<input type='submit' name='guardar' value='Guardar cambios' />
<?php } ?>

</form>

<?php if (!$nuevaEntrada) { ?>
    <br />
    <a href='PersonaEliminar.php?id=<?=$id ?>'>Eliminar persona</a>
<?php } ?>

<br />
<br />

<a href='PersonaListado.php'>Volver al listado de personas.</a>

</body>

</html>