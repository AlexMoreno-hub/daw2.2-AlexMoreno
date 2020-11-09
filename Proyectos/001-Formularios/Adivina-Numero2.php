<?php

    $oculto= (int) $_REQUEST["oculto"];

   if(isset($_REQUEST["intento"])) {
        $intento = (int) $_REQUEST["intento"];
        $numIntentos = (int) $_REQUEST["numIntentos"] + 1;

    }else {
            $intento = null;
            $numIntentos = 0;
        }


   //interfaz :   intento, oculto,
?>

<html>
<head>
</head>
<body>
<?php

 if ($intento != null) {

    if($intento < $oculto){
        echo "<p>El número que buscas es mayor </p>";
    } else if ($intento > $oculto){
        echo "<p>El número que buscas es menor </p>";
    } else if ($intento == $oculto) {
         echo "<p>¡Lo has acertado, era el: $oculto.</p>";
     }
  }

    if($intento != $oculto){
?>

<form method="post">
    <p>Jugador 2: Adivina el número (llevas <?= $numIntentos ?> intentos).</p>
    <input type="hidden" name="oculto" value="<?= $oculto ?>">
    <input type="hidden" name="numIntentos" value="<?= $numIntentos ?>">
    <input type="number" name="intento">
    <input type="submit" value="enviar">
</form>

</body>
</html>
        

<?php
    }
    ?>