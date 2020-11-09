<?php

    if (!isset($_REQUEST["color"])) $ciudad = false;
    $color = $_REQUEST["color"];
    ?>

<html>

<head>
    <meta charset='UTF-8'>
</head>

<body>
<?php
if (!$color) {
?>

<p>¿Cuál es tu color favorito?</p>
<form action='' method='get'>
    <input type='text' name='color' />
    <input type='submit' name='boton' value="Enviar" />
</form>

<?php
} else{
?>
<p>Tu color favorito es: <?=$color?>.</p>

<p>?=$color?></p>
<?php
}

?>
</body>

</html>
