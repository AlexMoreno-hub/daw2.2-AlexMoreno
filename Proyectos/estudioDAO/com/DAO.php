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
        $bd = "yt_colores"; // Schema
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
    /*
    $sql_leer = 'SELECT * FROM colores';

    $gsent = $pdo->prepare($sql_leer);
    $gsent->execute();

    $resultado = $gsent->fetchAll();
    */
    //Primero hacemos un metodo general para ejecutar todo y despues para obtener
    //LO ponemos como ejecutar consulta ; isset determina si una variable esta defenida

    private static function ejecutarConsulta(string $sql, array $parametros): array
    {
        if (!isset(self::$pdo)) self::$pdo = self::obtenerPdoConexionBd();

        $select = self::$pdo->prepare($sql);
        $select->execute($parametros);
        $rs = $select->fetchAll();

        return $rs;
    }


    private static function ColorCrearDesdeRs(array $fila): colores
    {
        return new colores($fila["id"], $fila["color"], $fila
        ["descripcion"]);
    }

    /*Obtener todas categorias*/
    public static function ObtenerTodos(): array
    {
        $datos = [];

        $rs = self::ejecutarConsulta(
            "SELECT * FROM colores ORDER BY color",
            []
        );

        foreach ($rs as $fila) {
            $colores = self::ColorCrearDesdeRs($fila);
            array_push($datos, $colores);
        }

        return $datos;
    }


    //CREAR necitamos el Insert
    /* $sql_agregar = 'INSERT INTO colores (color, descripcion) VALUES (?,?)';
    $sentencia_agregar = $pdo->prepare($sql_agregar);

    $sentencia_agregar->execute(array($color,$desc));

    header('location:index.php');*/
    private static function ejecutarActualizacion(string $sql, array $parametros): ?int
    {
        if (!isset(self::$pdo)) self::$pdo = self::obtenerPdoConexionBd();

        $actualizacion = self::$pdo->prepare($sql);
        $sqlConExito = $actualizacion->execute($parametros);

        if (!$sqlConExito) return null;
        else return $actualizacion->rowCount();
    }


    public static function colorCrear(string $color, string $descripcion)
    {
        self::ejecutarActualizacion(
            "INSERT INTO colores (color,descripcion) VALUES (?,?)",
            [$color, $descripcion]
        );
    }

    public static function editarColor($color, $descripcion, $id): bool
    {
        $resultado = self::ejecutarActualizacion("UPDATE colores SET color=?,descripcion=? WHERE id=?;",
            [$color, $descripcion, $id]
        );
        return $resultado;
    }

    public static function colorEliminar(int $id): ?int
    {
        $resultado = self::ejecutarActualizacion(
            "DELETE FROM colores WHERE id=?",
            [$id]
        );

        return $resultado;
    }

    public static function colorObtenerPorId(int $id): ?colores
    {
        $rs = self::ejecutarConsulta(
            "SELECT * FROM colores WHERE id=?",
            [$id]
        );
        if ($rs) return self::colorCrearDesdeRs($rs[0]);
        else return null;
    }

//COSAS PARA USUARIO

    ///// USUARIO ////////
    // FUNCION PARA CREAR USUARIO COMO OBJETO
    public static function usuarioCrearDesdeRs(array $rs): Usuario
    {
        return new Usuario($rs["id"], $rs["identificador"], $rs["contrasenna"], $rs["nombre"], $rs["apellidos"]);
    }

    // FUNCION PARA CREAR UN USUARIO Y AÑADIRLO LA BD
    public static function crearUsuario($identificador, $contrasenna, $nombre, $apellidos): bool
    {
        return self::ejecutarActualizacion(
            "INSERT INTO usuario (identificador, contrasenna, nombre , apellidos ) VALUES(?,?,?,?)",
            [$identificador, $contrasenna, $nombre, $apellidos]
        );
    }

    // FUNCION QUE REALIZA UNA MODIFICACION EN EL USUARIO YA ANTERIORMENTE CREADO
    public static function actualizarUsuarioEnBD($arrayUsuario)
    {
        return self::ejecutarActualizacion(
            "UPDATE usuario SET identificador=?, contrasenna=?, nombre=?, apellidos=? WHERE id=?",
            [$arrayUsuario[0], $arrayUsuario[1], $arrayUsuario[2], $arrayUsuario[3], $arrayUsuario[4]]
        );
    }

    // FUNCION PARA INICIAR SESION DEL USUARIO
    public static function obtenerUsuarioPorContrasenna(string $identificador, string $contrasenna): ?array
    {
        $rs = self::ejecutarConsulta(
            "SELECT * FROM Usuario WHERE identificador=? AND BINARY contrasenna=?",
            [$identificador, $contrasenna]
        );
        return $rs ? $rs[0] : null;
    }

    // FUNCION PARA OBTENER EL USUARIO POR CODIGO COOKIE
    public static  function obtenerUsuarioPorCodigoCookie(string $identificador, string $codigoCookie): ?array
    {
        // $rs = self::ejecutarConsulta("SELECT * FROM Usuario WHERE identificador=? AND BINARY codigoCookie=?", [$identificador,$codigoCookie]);
        $conexion = obtenerPdoConexionBD();
        $sql = "SELECT * FROM Usuario WHERE identificador=? AND BINARY codigoCookie=?";
        $select = $conexion->prepare($sql);
        $select->execute([$identificador, $codigoCookie]);
        $rs = $select->fetchAll();
        return $select->rowCount() == 1 ? $rs[0] : null;
    }

    // FUNCION QUE OBTIENE EL USUARIO POR SU ID
    public static function obtenerUsuarioPorId($id)
    {
        $rs = self::ejecutarConsulta(
            "SELECT * FROM Usuario WHERE id=?",
            [$id]
        );
        return $rs ? $rs[0] : null;
    }

    // FUNCION QUE OBTIENE LOS DATOS DEL USUARIO CUANDO ACCEDES A SU FICHA
    public static function usuarioFicha($id): Usuario
    {
        $rs = self::ejecutarConsulta("SELECT * FROM Usuario WHERE id=?", [$id]);
        $identificadorUsuario = $rs[0]["identificador"];
        $contrasennaUsuario = $rs[0]["contrasenna"];
        $nombreUsuario = $rs[0]["nombre"];
        $apellidosUsuario = $rs[0]["apellidos"];

        return new Usuario($id, $identificadorUsuario, $contrasennaUsuario, $nombreUsuario, $apellidosUsuario);
    }

    // FUNCION QUE AÑADE O CAMBIA LAS COOKIES EN LA BD
    public static function actualizarCodigoCookieEnBD(?string $codigoCookie): ?bool
    {
        $rs = self::ejecutarActualizacion("UPDATE Usuario SET codigoCookie=? WHERE id=?", [$codigoCookie, $_SESSION["id"]]);
        return $rs ? true : null;
    }

    //FUNCION PARA ACTUALIZAR LA SESION QUE SE ESTA USANDO
    public static function establecerSesionRam(array $arrayUsuario)
    {
        $_SESSION["id"] = $arrayUsuario["id"];
        $_SESSION["identificador"] = $arrayUsuario["identificador"];
        $_SESSION["tipoUsuario"] = $arrayUsuario["tipoUsuario"];
        $_SESSION["nombre"] = $arrayUsuario["nombre"];
        $_SESSION["apellidos"] = $arrayUsuario["apellidos"];
    }

    // FUNCION PARA REVISAR QUE EXISTE UNA SESION RAM
    public static function haySesionRamIniciada(): bool
    {
        return isset($_SESSION["id"]);
    }

    // FUNCION PARA BORRAR LAS COOKIES
    public static function borrarCookies()
    {
        setcookie("identificador", "", time() - 3600); // Tiempo en el pasado, para (pedir) borrar la cookie.
        setcookie("codigoCookie", "", time() - 3600); // Tiempo en el pasado, para (pedir) borrar la cookie.}
    }

    // FUNCION PARA EL CONTROL DE SESIONES Y COOKIES
    public static function intentarCanjearSesionCookie(): bool
    {
        if (isset($_COOKIE["identificador"]) && isset($_COOKIE["codigoCookie"])) {
            $arrayUsuario = self::obtenerUsuarioPorCodigoCookie($_COOKIE["identificador"], $_COOKIE["codigoCookie"]);
            if ($arrayUsuario) {
                self::establecerSesionRam($arrayUsuario);
                self::establecerSesionCookie($arrayUsuario); // Para regenerar el numero.
                return true;
            } else { // Venían cookies pero los datos no estaban bien.
                self::borrarCookies(); // Las borramos para evitar problemas.
                return false;
            }
        } else { // No vienen ambas cookies.
            self::borrarCookies(); // Las borramos por si venía solo una de ellas, para evitar problemas.
            return false;
        }
    }

    // FUNCION QUE MUESTRA LSO DATOS DE LA SESION
    public static function pintarInfoSesion()
    {
        if (self::haySesionRamIniciada()) {
            echo "<span class='text-center'>Sesión iniciada por $_SESSION[identificador]</a> ($_SESSION[nombre] $_SESSION[apellidos]) <a href='SesionCerrar.php'>Cerrar sesión</a></span>";
        } else {
            echo "<div class='text-center'>";
            echo "<a class='btn btn-outline-danger col-sm-5' href='SesionInicioFormulario.php'>Iniciar sesión</a> <br />";
            echo "<a class='btn btn-outline-danger col-sm-5' href='UsuarioNuevoFormulario.php'>Registrarse</a>";
            echo "</div>";
        }
    }

    //FUNCION PARA ACTUALIZAR LA COOKIE EN LA BD
    public static function establecerSesionCookie(array $arrayUsuario)
    {
        // Creamos un código cookie muy complejo (no necesariamente único).
        $codigoCookie = generarCadenaAleatoria(32); // Random...
        self::actualizarCodigoCookieEnBD($codigoCookie);

        // Enviamos al cliente, en forma de cookies, el identificador y el codigoCookie:
        setcookie("identificador", $arrayUsuario["identificador"], time() + 600);
        setcookie("codigoCookie", $codigoCookie, time() + 600);
    }

    // FUNCION PARA ELIMINAR LA SESION Y LA COOKIE (CERRAR SESION)
    public static function destruirSesionRamYCookie()
    {
        session_destroy();
        self::actualizarCodigoCookieEnBD(Null);
        self::borrarCookies();
        unset($_SESSION); // Por si acaso
    }

    // FUNCION QUE OBTIENE LA SESION YA ANTERIORMENTE INICIADA.
    public static function ObtenerSesionIniciada($id): array
    {
        // Aqui obtenemos la sesion y comprobamos que esta iniciada desde el id_usuario que reciboimos
        $datos = [];
        $rs = self::ejecutarConsulta(
            "SELECT * FROM usuario WHERE id=?",
            [$id]
        );
        $datos = array($rs["id"], $rs["identificador"], $rs["contrasenna"], $rs["nombre"], $rs["apellidos"]);
        // devolvemos el usuario en array
        return $datos;
    }


}