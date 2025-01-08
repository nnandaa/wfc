<?php
class Database
{
    private static $con = null;

    public static function Connect(): PDO
    {
        if (self::$con === null) {

            // $host = "sql210.infinityfree.com"; 
            // $username = "if0_37900500"; 
            // $password = "5L26ADheRAFWv2h"; 
            // $db = "if0_37900500_wfc";

            $host = "localhost";
            $username = "root";
            $password = "";
            $database = 'ecommerce';

            try {
                self::$con = new PDO("mysql:host=$host;dbname=ecommerce", $username, $password);
                self::$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }
        }
        return self::$con;
    }
}
