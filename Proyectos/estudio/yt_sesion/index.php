<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <a href="sesion.php">Iniciar Sesión</a>
    <a href="protegido.php">Contenido protegido</a>
    <h1>Bienvenido: <?php echo isset($_SESSION['admin']) ? $_SESSION['admin'] : 'Invitado' ?></h1>
</body>
</html>

