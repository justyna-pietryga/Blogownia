<?php

class DatabaseConnection {
    private static $instance = NULL;

    private static $host = "localhost";
    private static $db_user = "id3479013_blogownia_admin";
    private static $db_password = "qwertyqwerty";
    private static $db_name = "id3479013_blogownia";


    /*private static $host = "mysql.cba.pl";
    private static $db_user = "mystery-of-silen";
    private static $db_password = "Qwertyqwerty96";
    private static $db_name = "mystery_of_silence"; */

    private function __construct() {}

    private function __clone() {}

    public static function getInstance() {

        if (!isset(self::$instance)) {
            // $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
            // self::$instance = new PDO('mysql:host=localhost;dbname=php_mvc', 'root', '', $pdo_options);
            try{
                self::$instance = new PDO('mysql:host='.DatabaseConnection::$host.';dbname='.DatabaseConnection::$db_name.
                    ';charset=utf8', DatabaseConnection::$db_user, DatabaseConnection::$db_password );
            }catch(PDOException $e){
                echo 'Błąd połączenia z bazą danych';
            }
        }
        return self::$instance;
    }
}
