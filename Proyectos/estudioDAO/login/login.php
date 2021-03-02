<?php

session_start();

include_once '../com/DAO.php';

$nombre_usuario = $_REQUEST['nombre_usuario'];
$contrasena_login = $_REQUEST['contrasena'];


/*
//VERIFICAR SI USUARIO EXISTE
$sql = 'SELECT * FROM usuarios WHERE nombre = ?';
$sentencia = $pdo->prepare($sql);
$sentencia->execute(array($usuario_login));
$resultado = $sentencia->fetch();*/

$resultado = DAO::obtenerUsuario($nombre_usuario,$contrasena_login);
if(!$resultado){
    //matar la operación
    echo 'No exite usuario';
    die();
}

redireccionar("../index.php");
/*
if( password_verify( $contrasena_login , $resultado['contrasena']) ){
    //las contraseñas son iguales
    $_SESSION['admin'] = $nombre_usuario;
    header('Location: ../index.php');

}else{
    echo 'No son iguales las contraseñas!';
    die();
}*/



