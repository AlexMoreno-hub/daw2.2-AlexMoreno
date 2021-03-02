<?php
require_once "_com/Varios.php";
require_once "_com/DAO.php";


$personas = DAO::personaObtenerTodos();
?>



<html>

<head>
    <meta charset='UTF-8'>
</head>



<body>

<h1>Listado de Personas</h1>

<table border='1'>

    <tr>
        <th>Persona</th>
        <th>Apellidos</th>
        <th>Categoría</th>
    </tr>

    <?php
    foreach ($personas as $fila) { ?>
        <tr>
            <td>
                <a href='personaFicha.php?id=<?=$fila->getId()?>'> <?= $fila->getNombre() ?> </a>
                <a href='personaEstablecerEstadoEstrella.php?id=<?=$fila->getId()?>'>
                    <img src='$urlImagen' width='25' height='15'></a>
            </td>
            <td><a href='personaFicha.php?id=<?=$fila->getId()?>'> <?= $fila->getApellidos() ?> </a></td>
            <td><a href='personaFicha.php?id=<?=$fila->getId()?>'> <?= $fila->getpersonaCategoriaId() ?> </a></td>
            <td><a href='personaEliminar.php?id=<?=$fila->getId()?>'> (X)                      </a></td>
        </tr>
    <?php } ?>
</table>

<br />

<?php if (!isset($_SESSION["soloEstrellas"])) {?>
    <a href='PersonaListado.php?soloEstrellas'>Mostrar solo contactos con estrella</a>
<?php } else { ?>
    <a href='PersonaListado.php?todos'>Mostrar todos los contactos</a>
<?php } ?>

<br />
<br />

<a href='PersonaFicha.php?id=-1'>Crear entrada</a>

<br />
<br />

<a href='CategoriaListado.php'>Gestionar listado de Categorías</a>

</body>

</html>