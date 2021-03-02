<?php

include_once '../com/DAO.php';

//echo password_hash("bluuweb", PASSWORD_DEFAULT)."\n";

//CAPTURAR DATOS POR POST
$nombre = $_POST['nombre_usuario'];
$contrasena = $_POST['contrasena'];
$contrasena2 = $_POST['contrasena2'];



//VERIFICAR SI USUARIO EXISTE
/*
$sql = 'SELECT * FROM usuarios WHERE nombre = ?';
$sentencia = $pdo->prepare($sql);
$sentencia->execute(array($usuario_nuevo));
$resultado = $sentencia->fetch();*/

$resultado = Dao::comprobarUsuario($nombre);

var_dump($resultado);
//SI EXISTE USUARIO MATAMOS LA OPERACIÓN
if($resultado){
    echo '</br>Existe este usuario';
    die();
}

//HASH DE CONTRASEÑA
$contrasena = password_hash($contrasena, PASSWORD_DEFAULT);

//VERIFICAR CONTRASEÑA
if (password_verify($contrasena2, $contrasena)) {


    //AGREGAR A LA BASE DE DATOS
/*
    $sql_agregar = 'INSERT INTO usuarios (nombre,contrasena) VALUES (?,?)';
    $sentencia_agregar = $pdo->prepare($sql_agregar);
    $sentencia_agregar->execute(array($usuario_nuevo,$contrasena)) ;
        //header('location:registro.php');*/
    $resultado = DAO::usuarioCrear($nombre,$contrasena);


    //cerramos conexión base de datos y sentencia
    $sentencia_agregar = null;
    $pdo = null;
  //  header('location:registro.php');


} else {
    echo 'La contraseña no es válida.';
}


