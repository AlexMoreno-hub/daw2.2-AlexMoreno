<?php

require_once "_varios.php";

class DAO
{
    private static $pdo = null;

    private static function obtenerPdoConexionBD()
    {
        $servidor = "localhost";
        $bd = "MiniFb";
        $identificador = "root";
        $contrasenna = "";
        $opciones = [
            PDO::ATTR_EMULATE_PREPARES   => false, // turn off emulation mode for "real" prepared statements
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, //turn on errors in the form of exceptions
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //make the default fetch be an associative array
        ];

        try {
            $conexion = new PDO("mysql:host=$servidor;dbname=$bd;charset=utf8", $identificador, $contrasenna, $opciones);
        } catch (Exception $e) {
            error_log("Error al conectar: " . $e->getMessage()); // El error se vuelca a php_error.log
            exit('Error al conectar'); //something a user can understand
        }

        return $conexion;
    }
    private static function ejecutarConsulta(string $sql, array $parametros): array
    {
        if (!isset(self::$pdo)) self::$pdo = self::obtenerPdoConexionBd();

        $select = self::$pdo->prepare($sql);
        $select->execute($parametros);
        $rs = $select->fetchAll();

        return $rs;
    }

    // Devuelve:
    //   - null: si ha habido un error
    //   - 0, 1 u otro número positivo: OK (no errores) y estas son las filas afectadas.
    private static function ejecutarActualizacion(string $sql, array $parametros): ?int
    {
        if (!isset(self::$pdo)) self::$pdo = self::obtenerPdoConexionBd();

        $actualizacion = self::$pdo->prepare($sql);
        $sqlConExito = $actualizacion->execute($parametros);

        if (!$sqlConExito) return null;
        else return $actualizacion->rowCount();
    }


    public static function obtenerUsuarioPorContrasenna(string $identificador, string $contrasenna): ? usuario
    {
        $rs = self::ejecutarConsulta(
            "SELECT * FROM usuario WHERE identificador =? AND contrasenna =?",
            [$identificador, $contrasenna]
        );
        if ($rs) return self::usuarioCrearDesdeRS($rs[0]);
        else return null;
    }

    private static function usuarioCrearDesdeRS(array $usuario): usuario
    {
        return new usuario($usuario["id"], $usuario["identificador"],$usuario["contrasenna"], $usuario["codigoCookie"],
        $usuario["caducidadCodigoCookie"],$usuario["tipoUsuario"],$usuario["nombre"],$usuario["apellidos"]);
    }

    private static function obtenerUsuarioPorCodigoCookie(string $identificador, string $codigoCookie): ?array
    {
        $rs = self::ejecutarConsulta(
            "SELECT * FROM usuario WHERE identificador =? AND BINARY codigoCookie =?",
            [$identificador, $codigoCookie]
        );
        if ($rs) return self::usuarioCrearDesdeRS($rs[0]);
        else return null;
    }


    private static function actualizarCodigoCookieEnBD(?string $codigoCookie)
    {
        self::ejecutarActualizacion(
            "UPDATE Usuario SET codigoCookie=? WHERE id=?",
            [$codigoCookie, $_SESSION["id"]]
        );
        // TODO Para una seguridad óptima convendría anotar en la BD la fecha de caducidad de la cookie y no aceptar ninguna cookie pasada dicha fecha.
    }


    private static function borrarCookies()
    {
        setcookie("nombreUsuario", "", time() - 3600);
        setcookie("codigoCookie", "", time() - 3600); //borrar cookie en ese tiempo
    }

    private static function establecerSesionCookie()
    {
        $arrayUsuario = DAO::obtenerUsuarioPorContrasenna($_REQUEST["identificador"], $_REQUEST["contrasenna"]);
        $codigoCookie = generarCadenaAleatoria(32);

        self::ejecutarConsulta(
            "UPDATE usuario SET codigoCookie=? WHERE identificador=?",
            [$codigoCookie, $arrayUsuario->getIdentificador()]
        );


        $arrayCookies["identificador"] = setcookie("identificador", $arrayUsuario->getIdentificador(), time() + 600);
        $arrayCookies["codigoCookie"] = setcookie("codigoCookie", $codigoCookie, time() + 600);
    }

    public static function haySesionRamIniciada(): bool
    {
        return isset($_SESSION["id"]);
    }


    public static function cerrarSesionRamYCookie()
    {
        session_destroy();
        unset($_SESSION); // Por si acaso

        if (isset($_COOKIE["codigoCookie"])) {
            unset($_COOKIE["codigoCookie"]);
            setcookie("codigoCookie", "", time() - 3600);
        }

        if (isset($_COOKIE["identificador"])) {
            unset($_COOKIE["identificador"]);
            setcookie("identificador", "", time() - 3600);
        }
    }



    private static function intentarCanjearSesionCookie(): bool
    {
        if (isset($_COOKIE["identificador"]) && isset($_COOKIE["codigoCookie"])) {
            $arrayUsuario = obtenerUsuarioPorCodigoCookie($_COOKIE["identificador"], $_COOKIE["codigoCookie"]);

            if ($arrayUsuario) {
                establecerSesionRam($arrayUsuario);
                establecerSesionCookie($arrayUsuario); // Para re-generar el numerito.
                return true;
            } else { // Venían cookies pero los datos no estaban bien.
                borrarCookies(); // Las borramos para evitar problemas.
                return false;
            }
        } else { // No vienen ambas cookies.
            borrarCookies(); // Las borramos por si venía solo una de ellas, para evitar problemas.
            return false;
        }
    }

    private static function establecerSesionRam(array $arrayUsuario)
    {
        // Anotar en el post-it como mínimo el id.
        $_SESSION["id"] = $arrayUsuario["id"];

        // Además, podemos anotar todos los datos que podamos querer tener a mano, sabiendo que pueden quedar obsoletos...
        $_SESSION["identificador"] = $arrayUsuario["identificador"];
        $_SESSION["tipoUsuario"] = $arrayUsuario["tipoUsuario"];
        $_SESSION["nombre"] = $arrayUsuario["nombre"];
        $_SESSION["apellidos"] = $arrayUsuario["apellidos"];
    }


    public function sessionStartSiNoLoEsta()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
    }

// Comprueba si hay sesión-usuario iniciada en la sesión-RAM.
    public function haySesionIniciada()
    {
        sessionStartSiNoLoEsta();
        return isset($_SESSION['sesionIniciada']);
    }
}
    ?>