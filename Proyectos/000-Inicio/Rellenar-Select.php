 <?php
$ciudades = [
17 => "Donosti",
8 => "Getafe",
4 => "Toledo",
71 => "Granada",
52 => "Lugo",
47 => "Zaragoza"
];
?>



<html>

<head>
    <meta charset='UTF-8'>
</head>

<body>

<select name='ciudadId'>
    <option value='-1'>&lt;ELIJA&gt;</option>
    <?php
    foreach ($ciudades as $id => $denominacion) {
        echo "<option value='$id'>$denominacion</option>\n";
    }
    ?>
</select>

</body>

</html>