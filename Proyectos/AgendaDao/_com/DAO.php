<?php

require_once "Clases.php";
require_once "Varios.php";

class DAO
{
    private static $pdo = null;

    private static function obtenerPdoConexionBD()
    {
        $servidor = "localhost";
        $identificador = "root";
        $contrasenna = "";
        $bd = "Agenda"; // Schema
        $opciones = [
            PDO::ATTR_EMULATE_PREPARES => false, // Modo emulación desactivado para prepared statements "reales"
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Que los errores salgan como excepciones.
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // El modo de fetch que queremos por defecto.
        ];

        try {
            $pdo = new PDO("mysql:host=$servidor;dbname=$bd;charset=utf8", $identificador, $contrasenna, $opciones);
        } catch (Exception $e) {
            error_log("Error al conectar: " . $e->getMessage());
            exit("Error al conectar" . $e->getMessage());
        }

        return $pdo;
    }

    private static function ejecutarConsulta(string $sql, array $parametros): array
    {
        if (!isset(self::$pdo)) self::$pdo = self::obtenerPdoConexionBd();

        $select = self::$pdo->prepare($sql);
        $select->execute($parametros);
        $rs = $select->fetchAll();

        return $rs;
    }

    private static function ejecutarActualizacion(string $sql, array $parametros): bool
    {
        if (!isset(self::$pdo)) self::$pdo = self::obtenerPdoConexionBd();

        $actualizacion = self::$pdo->prepare($sql);
        $sqlConExito = $actualizacion->execute($parametros);

        return $sqlConExito;
    }



    /* CATEGORÍA */

    private static function categoriaCrearDesdeRs(array $fila): Categoria
    {
        return new Categoria($fila["id"], $fila["nombre"]);
    }

    public static function categoriaObtenerPorId(int $id): ?Categoria
    {
        $rs = self::ejecutarConsulta(
            "SELECT * FROM Categoria WHERE id=?",
            [$id]
        );
        if ($rs) return self::categoriaCrearDesdeRs($rs[0]);
        else return null;
    }

    public static function categoriaActualizar($id, $nombre)
    {
        self::ejecutarActualizacion(
            "UPDATE Categoria SET nombre=? WHERE id=?",
            [$nombre, $id]
        );
    }

    public static function categoriaCrear(string $nombre)
    {
        self::ejecutarActualizacion(
            "INSERT INTO Categoria (nombre) VALUES (?)",
            [$nombre]
        );
    }

    public static function categoriaObtenerTodas(): array
    {
        $datos = [];
        $rs = self::ejecutarConsulta(
            "SELECT * FROM Categoria ORDER BY nombre",
            []
        );

        foreach ($rs as $fila) {
            $categoria = self::categoriaCrearDesdeRs($fila);
            array_push($datos, $categoria);
        }

        return $datos;
    }


    public static function categoriaModificar($nombre, $id): bool
    {
        $consulta = self::ejecutarActualizacion("UPDATE categoria SET nombre=? WHERE id=?;", [$id, $nombre]);
        return $consulta;
    }


    public static function categoriaEliminar(int $id): ?int
    {
        $resultado = self::ejecutarActualizacion(
            "DELETE FROM Categoria WHERE id=?",
            [$id]
        );

        return $resultado;
    }

    public static function mostrarPersonas($id)
    {

        return   $rs = self::ejecutarConsultaMostrar(
            "SELECT * FROM persona WHERE categoriaId=? ORDER BY nombre",
            [$id]
        );

    }
    //Personas


    public static function personaEliminar(int $id): ?int
    {
        $resultado = self::ejecutarActualizacion(
            "DELETE FROM persona WHERE id=?",
            [$id]
        );

        return $resultado;
    }

    public static function personaObtenerTodos(): array
    {

        $mostrarEstrella = isset($_REQUEST["soloEstrellas"]);

        session_start(); // Crear post-it vacío, o recuperar el que ya haya  (vacío o con cosas).
        if (isset($_REQUEST["soloEstrellas"])) {
            $_SESSION["soloEstrellas"] = true;
        }
        if (isset($_REQUEST["todos"])) {
            unset($_SESSION["soloEstrellas"]);
        }

        $posibleClausulaWhere = $mostrarEstrella ? "WHERE p.lesionado=1" : "";
        $datos = [];

        $rs = self::ejecutarConsulta(
            "SELECT
                    p.id     AS pId,
                    p.nombre AS pNombre,
                    p.apellidos AS pApellidos,
                    p.estrella AS pEstrella,
                    c.id     AS cId,
                    c.nombre AS cNombre
                FROM
                   Persona AS p INNER JOIN Categoria AS c
                   ON p.categoriaId = c.id
                $posibleClausulaWhere
                ORDER BY p.nombre",
            []
        );

        foreach ($rs as $fila) {
            $persona = self::personaCrearDesdeRs($fila);
            array_push($datos, $persona);
        }

        return $datos;
    }

    public static function personaCrearDesdeRs(array $fila): persona
    {
        return new persona($fila["pId"], $fila["pNombre"],$fila["pApellidos"],$fila["pEstrella"],$fila["cId"]);
    }




    private static function ejecutarConsultaMostrar(string $sql, array $parametros): array
    {
        if (!isset(self::$pdo)) self::$pdo = self::obtenerPdoConexionBd();

        $select = self::$pdo->prepare($sql);
        $select->execute($parametros);
        $rsPersonasDelaCategoria = $select->fetchAll();

        foreach ($rsPersonasDelaCategoria as $fila) {
            echo "<li>$fila[nombre] $fila[apellidos]</li>";
        }
        return $rsPersonasDelaCategoria;
    }

    public static function personaObtenerPorId(int $id): ?persona
    {
        $rs = self::ejecutarConsultaObtener(
            "SELECT * FROM persona WHERE id=?",
            [$id]
        );
        if ($rs) return self::personaCrearDesdeRs1($rs[0]);
        else return null;
    }
    private static function personaCrearDesdeRs1(array $fila): persona
    {
        return new persona($fila["id"], $fila["nombre"],$fila["apellidos"],$fila["estrella"],$fila["categoriaId"]);
    }

    public static function ejecutarConsultaObtener(string $sql, array $parametros): ?array
    {
        if (!isset(DAO::$pdo)) DAO::$pdo = DAO::obtenerPdoConexionBd();

        $sentencia = DAO::$pdo->prepare($sql);
        $sentencia->execute($parametros);
        $resultado = $sentencia->fetchAll();
        return $resultado;
    }

    public static function personaSelectCategoria(): array
    {
        $rs = self::ejecutarConsulta(
            "SELECT id, nombre FROM categoria order by nombre",
            []
        );
        return $rs;
    }

    public static function personaModificar($nombre,$apellidos,$categoriaId,$estrella): bool
    {
        $consulta = self::ejecutarActualizacion("UPDATE persona SET nombre=?, apellidos=?, estrella=?,categoriaId=? WHERE id=?;",
            [$nombre,$apellidos,$estrella,$categoriaId,$id]);
        return $consulta;
    }

    public static function personaCrear($nombre,$apellidos,$categoriaId,$estrella): bool
    {

        $consulta = self::ejecutarActualizacion("INSERT INTO persona (nombre,apellidos,categoriaId,estrella) VALUES (?,?,?,?);",
            [$nombre,$apellidos,$categoriaId,$estrella]);

        return $consulta;
    }
}