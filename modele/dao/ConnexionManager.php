<?php
class ConnexionManager {
    private static $connexion;

    public static function getConnexion() {
        if (self::$connexion === null) {
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "mglsi_news";
            self::$connexion = new mysqli($servername, $username, $password, $dbname);
            if (self::$connexion->connect_error) {
                die("Connection échouée: " . self::$connexion->connect_error);
            }
        }
        return self::$connexion;
    }

    public static function closeConnexion() {
        if (self::$connexion !== null) {
            self::$connexion->close();
        }
    }
}
?>
