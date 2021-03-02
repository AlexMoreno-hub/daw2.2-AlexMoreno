<?php

//hacer una conexion a la bdd
    //la variable link nos dice el nombre del host y de la base
    $link='mysql:host=localhost;dbname=yt_colores';
    $usuario='root';
    $contrasenna='root';

    try{
        //nuestra Pdo = a nuestro link, usuario y contrasenna
        $pdo = new PDO($link,$usuario,$contrasenna);


    }catch (PDOException $e){
        error_log("Error al conectar".$e->getMessage());
        exit("Error al conectar".$e->getMessage());
    }
    return $pdo;

?>