<?php
// REQUERIMIENTOS
require_once "_com/_dao.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Registrarse</title>
</head>

<body>
<form class="col-md-12 text-center" action='UsuarioNuevoCrear.php' method="post">
    <h1 class="text-center">Registrarse</h1>
    <input class="col-sm-5" type='text' name='identificador' placeholder="Identificador / Nombre de Usuario" required><br><br>
    <input class="col-sm-5" type='password' name='contrasenna' id='contrasenna' placeholder="Contraseña" required><br><br>
    <input class="col-sm-5" type='text' name='nombre' id='nombre' placeholder="Nombre" required><br><br>
    <input class="col-sm-5" type='text' name='apellidos' id='apellidos' placeholder="Apellidos" required><br><br>
    <!-- BOTON -->
    <input class="btn btn-outline-success col-sm-5" type='submit' value='Registrarse'>
    <p>O, si tienes una cuenta , <a href='SesionInicioFormulario.php'>Iniciala aquí</a>.</p>
</form>
</body>

</html>