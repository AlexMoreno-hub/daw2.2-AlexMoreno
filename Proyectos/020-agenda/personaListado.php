<?php

require_once "_varios.php";

$pdo = obtenerPdoConexionBD();

$sql = "
           SELECT
                p.id     AS p_id,
                p.nombre AS p_nombre,
                c.id     AS c_id,
                c.nombre AS c_nombre
            FROM
               persona p, categoria c
               WHERE p.categoria_id = c.id
            ORDER BY p.nombre
    ";

$select = $pdo->prepare($sql);
$select->execute([]); // Array vacío porque la consulta preparada no requiere parámetros.
$rs = $select->fetchAll();
?>

<html>

<head>
    <meta charset="UTF-8">
</head>



<body>

<h1>Listado de Personas</h1>

<table border="1">

    <tr>
        <th>Nombre</th>
    </tr>

    <?php
    foreach ($rs as $fila) { ?>
        <tr>
            <td><a href="persona-ficha.php?id=<?=$fila["p_id"]?>"> <?=$fila["p_nombre"] ?> </a></td>
            <td><a href="persona-eliminar.php?id=<?=$fila["p_id"]?>"> (X)                   </a></td>
        </tr>
    <?php } ?>

</table>

<br />

<a href="persona-ficha.php?id=-1">Crear entrada</a>

<br />
<br />

<a href="persona-listado.php">Gestionar listado de Personas</a>

</body>

</html>