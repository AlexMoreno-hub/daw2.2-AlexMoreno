<?php
require_once "_varios.php";

$pdo = obtenerPdoConexionBD();

$id = (int)$_REQUEST["id"];

$nueva_entrada = ($id == -1);

if ($nueva_entrada) {
    $persona_nombre = "<introduzca nombre>";
    $personaApellidos = "<introduzca apellidos>";
    $persona_telefono = "<introduzca telefono>";
    $personaCategoriaId = "<introduzca el id de su categoria>";
} else {
    $sqlPersona = "SELECT nombre, apellidos , telefono, categoriaId FROM persona WHERE id=?";

    $select = $pdo->prepare($sqlPersona);
    $select->execute([$id]);
    $rs = $select->fetchAll();

    $persona_nombre = $rs[0]["nombre"];
    $personaApellidos = $rs[0]["apellidos"];
    $persona_telefono = $rs[0]["telefono"];
    $personaCategoriaId = $rs[0]["categoria_id"];
}
// Con lo siguiente se deja preparado un recordset con todas las categorías.

$sqlCategorias = "SELECT id, nombre FROM categoria ORDER BY nombre";

$select = $pdo->prepare($sqlCategorias);
$select->execute([]); // Array vacío porque la consulta preparada no requiere parámetros.
$rsCategorias = $select->fetchAll();



// INTERFAZ:
// personaNombre
// personaTelefono
// personaCategoriaId
// rsCategorias
?>




<html>

<head>
    <meta charset='UTF-8'>
</head>



<body>

<?php if ($nueva_entrada) { ?>
    <h1>Nueva ficha de persona</h1>
<?php } else { ?>
    <h1>Ficha de persona</h1>
<?php } ?>

<form method='post' action='personaGuardar.php'>

    <input type='hidden' name='id' value='<?= $id ?>' />

    <ul>
        <li>
            <strong>Nombre: </strong>
            <input type='text' name='nombre' value='<?=$persona_nombre ?>' />
        </li>
        <li>
        <strong>Apellidos: </strong>
        <input type='text' name='apellidos' value='<?=$personaApellidos ?>' />
        </li>
        <li>
            <strong>Teléfono: </strong>
            <input type='text' name='telefono' value='<?=$persona_telefono ?>' />
        </li>
        <li>
            <strong>Categoría: </strong>
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
        </li>
    </ul>

    <?php if ($nueva_entrada) { ?>
        <input type='submit' name='crear' value='Crear persona' />
    <?php } else { ?>
        <input type='submit' name='guardar' value='Guardar cambios' />
    <?php } ?>

</form>

<?php if (!$nueva_entrada) { ?>
    <br />
    <a href='personaEliminar.php?id=<?=$id ?>'>Eliminar persona</a>
<?php } ?>

<br />
<br />

<a href='personaListado.php'>Volver al listado de personas.</a>

</body>

</html>