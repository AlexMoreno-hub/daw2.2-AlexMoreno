<?php
include_once 'conexion.php';


//LEER
$sql_leer = 'SELECT * FROM colores';

$gsent = $pdo->prepare($sql_leer);
$gsent->execute();

$resultado = $gsent->fetchAll();

//var_dump($resultado);


//AGREGAR
if($_POST)
{
    $color  =  $_REQUEST['color'];
    $desc  =  $_REQUEST['descripcion'];

    $sql_agregar = 'INSERT INTO colores (color, descripcion) VALUES (?,?)';
    $sentencia_agregar = $pdo->prepare($sql_agregar);

    $sentencia_agregar->execute(array($color,$desc));

    header('location:index.php');
}

//EDITAR
//CAPTURAR ID PARA EDITAR
if ($_GET)
{
    $id = $_REQUEST['id'];

    $sql_unico = 'SELECT * FROM colores WHERE id = ?';
    $gsent_unico = $pdo->prepare($sql_unico);
    $gsent_unico->execute(array($id));
    $resultado_unico = $gsent_unico->fetch();

    //var_dump($resultado_unico);
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

            <?php foreach($resultado as $dato): ?>

                <div
                    class="alert alert-primary "
                    role="alert">

                    <?php echo $dato['color']; ?>
                    -
                    <?php echo $dato['descripcion']; ?>

                    <a href="index.php?id=<?php echo $dato['id']; ?>">Editar

                    </a>

                    <a href="eliminar.php?id=<?php echo $dato['id']; ?>" >X</a>

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

                    <input type="text" class="form-control" name="color" required="on" value="<?php echo $resultado_unico['color']; ?>">

                    <input type="text" class="form-control mt-3" name="descripcion" required="on" value="<?php echo $resultado_unico['descripcion']; ?>">

                    <input type="hidden" name="id" value="<?php echo $resultado_unico['id']; ?>">

                    <button class="btn btn-primary mt-3">Editar Color</button>

                </form>

            <?php endif ?>

        </div>

    </div>

</div>

</body>
</html>