<?php

$colores = [
    1 => "Rojo",
    2 => "Naranja",
    3 => "Amarillo",
    4 => "verde",
];
?>

<html>

<head>
    <meta charset='UTF-8'>
</head>

<body>

<select name='colorId'>
    <option value='-1'>&lt;Elige un color&gt;</option>
    <?php
    foreach ($colores as $id => $color) {
        echo "<option value='$id'>$color</option>\n";
    }
    ?>
</select>


</body>

</html>
