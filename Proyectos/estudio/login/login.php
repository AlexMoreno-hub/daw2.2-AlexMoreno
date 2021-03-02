<?php

session_start();

include_once '../conexion.php';

$usuario_login = $_POST['nombre_usuario'];
$contrasena_login = $_POST['contrasena'];

//VERIFICAR SI USUARIO EXISTE
$sql = 'SELECT * FROM usuarios WHERE nombre = ?';
$sentencia = $pdo->prepare($sql);
$sentencia->execute(array($usuario_login));
$resultado = $sentencia->fetch();

if(!$resultado){
    //matar la operación
    echo 'No exite usuario';
    die();
}


if( password_verify( $contrasena_login , $resultado['contrasena']) ){
    //las contraseñas son iguales
    $_SESSION['admin'] = $usuario_login;
    header('Location: ../index.php');

}else{
    echo 'No son iguales las contraseñas!';
    die();
}

