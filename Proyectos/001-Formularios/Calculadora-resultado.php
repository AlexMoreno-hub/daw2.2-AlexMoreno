<?php
$numero1 = $_GET['numero1'];
$numero2 = $_GET['numero2'];
$operacion= $_GET['operacion'];

if($operacion == "+"){
    $resultado = $numero1 + $numero2;
}else if($operacion == "-"){
    $resultado = $numero1 - $numero2;
}else if($operacion == "x"){
    $resultado = $numero1 * $numero2;
}else if($operacion == "/"){
    $resultado = $numero1 / $numero2;
}

//Interfaz
// resultado, numero1,numero2,

?>

<html>
<head>
</head>
<body>
<?php
echo "<p> El resultado de la operacion es  $resultado.</p>";
?>
</body>
</html>
