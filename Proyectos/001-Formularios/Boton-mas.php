<?php

if (!isset($_REQUEST["acumulado"]) || isset($_REQUEST["reset"])) { // Si NO hay formulario enviado (1ª vez), o piden resetear.
    $acumulado = 0;
} else { // Sí hay formulario enviado (2ª ó siguientes veces).
    $acumulado = (int) $_REQUEST["acumulado"] + 1;
    //si ya hay un numero en el formulario , transforma a int, coges ese numero y le sumas 1
}

?>


<html>

<form method='get'>

     <input type='text' name='acumulado' value='<?=$acumulado?>'>
    <!-- Este input crea un cuadro de texto en el que guarda el valor acumulado-->

    <input type='submit' value='+1' name='suma'>
    <!-- Este input crea un boton , en el boton sale como  +1 y lo llama suma -->

    <br /><br />

    <input type='submit' value='Resetear' name='reset'>

    <br /><br />

    <!-- Resetear mandando un link a la pagina principal   -->
    <a href='<?= $_SERVER["PHP_SELF"] ?>'>Otra manera de resetear</a>
    <br/><span>(Esta parece la mejor)</span>

</form>

</html>