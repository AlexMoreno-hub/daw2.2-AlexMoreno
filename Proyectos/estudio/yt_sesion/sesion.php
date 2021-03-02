<?php
session_start();
$login = 'Ignacio';

$_SESSION['admin'] = $login;

if( isset($_SESSION['admin']) ){
    header('Location:index.php');
}

// echo '<br>';
// var_dump($_SESSION);

