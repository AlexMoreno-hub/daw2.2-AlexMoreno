
<html lang="en">
<head>
    <title>Calculadora</title>
</head>
<body>
<form action="Calculadora-resultado.php" method="get">
    <h1>Introduzca el primer numero</h1>
    <input name= "numero1" type="number">
    <select name="operacion">
        <option value="+">Suma</option>
        <option value="-">Resta</option>
        <option value="x">Multiplica</option>
        <option value="/">Divide</option>
    </select>

    <h2>Introduzca el segundo numero</h2>
    <input name= "numero2" type="number">
    <input type="submit" value="Calcular">
</form>
</body>
</html>
