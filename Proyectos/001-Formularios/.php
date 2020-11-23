
<?php

    $oculto = (int) $_REQUEST["oculto"];

    if (isset($_REQUEST["intento"])) {
        $intento = (int) $_REQUEST["intento"];
        $numIntentos = (int) $_REQUEST["numIntentos"] + 1;

    } else {
        $intento = null;
        $numIntentos = 0;
    }

?>



<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>

<body>

<h1>ADIVINA EL NÚMERO</h1>


<?php

    if ($intento == null) {
        // No informamos de nada, el juego acaba de empezar.
    } elseif ($intento < $oculto) {
        echo "<p>El número que buscas es mayor ($cercania)</p>";
    } elseif ($intento > $oculto) {
        echo "<p>El número que buscas es menor ($cercania)</p>";
    } else {
        echo "<p>¡Has adivinado el número! Era, efectivamente, $oculto.</p>";
    }

    if ($intento != $oculto) { // Presentamos el formulario:

        ?>

        <form method="post">
            <p>Jugador 2: Adivina el número (llevas <?= $numIntentos ?> intentos).</p>
            <input type="hidden" name="oculto" value="<?= $oculto ?>">
            <input type="hidden" name="numIntentos" value="<?= $numIntentos ?>">
            <input type="number" name="intento">
            <input type="submit" value="enviar">
        </form>

        <?php

    }

?>

</body>

</html>