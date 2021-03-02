<?php

require_once 'com/DAO.php';

//LEER
$resultado = DAO::ObtenerTodos();

/*
//AGREGAR
if($_POST)
{
    $color  =  $_REQUEST['color'];
    $desc  =  $_REQUEST['descripcion'];

    $sql_agregar = 'INSERT INTO colores (color, descripcion) VALUES (?,?)';
    $sentencia_agregar = $pdo->prepare($sql_agregar);

    $sentencia_agregar->execute(array($color,$desc));

    header('location:index.php');
}*/
   if($_POST )  {
       $color = $_REQUEST['color'];
       $desc = $_REQUEST['descripcion'];

       $resultado=false;
        $resultado=dao::colorCrear($color,$desc);
        redireccionar("index.php");

   }


//EDITAR
//CAPTURAR ID PARA EDITAR

if ($_GET)
{
    $id=$_REQUEST['id'];
    $resultado_unico= dao::colorObtenerPorId($id);
    $color= $resultado_unico->getColor();
    $descripcion= $resultado_unico->getDescripcion();
   // var_dump($resultado_unico);
    //var_dump($color);
}

//cerrar base de datos
$sentencia_agregar = null;



?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <script src="all.js"></script>

    <title>Hello, world!</title>
</head>
<body>
<div class="container">

    <div class="row">

        <div class="col-md-6">

            <?php foreach($resultado as $fila): ?>

                <div
                    class="alert alert-primary "
                    role="alert">


                        <?=$fila->getColor()?> </a>
                        <?=$fila->getDescripcion()?></a>

                    <a href='index.php?id=<?=$fila->getId()?>'>Editar</a>

                    <a href='eliminar.php?id=<?=$fila->getId()?>'> (X) </a>


                </div>

            <?php
            endforeach
            ?>
        </div>

        <div class="col-md-6">


            <?php if(!$_GET): ?>

                <form method="POST">

                    <h2>AGREGAR NUEVO COLOR</h2>

                    <input type="text" class="form-control" name="color" required="on">

                    <input type="text" class="form-control mt-3" name="descripcion" required="on">

                    <button class="btn btn-primary mt-3">Agregar Color</button>

                </form>

            <?php endif ?>

            <?php if($_GET): ?>

                <form method="GET" action="editar.php">

                    <h2>EDITAR EL COLOR</h2>

                    <input type="text" class="form-control" name="color" required="on" value='<?=$color ?>'>

                    <input type="text" class="form-control mt-3" name="descripcion" required="on" value="<?=$descripcion ?>">

                    <input type="hidden" name="id" value="<?=$id?>">

                    <button class="btn btn-primary mt-3">Editar Color</button>

                </form>

            <?php endif ?>

        </div>

    </div>

</div>

</body>
</html>