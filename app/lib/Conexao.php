<?php
namespace lib;

use PDO;
use PDOException;

class Conexao 
{  
    private static $pdo;
 
    private function __construct() {}

    public static function getInstance() 
    {  
        if (!isset(self::$pdo)) {  
            try {  
                self::$pdo = new PDO("pgsql:host=" . DB_HOST . "; dbname=" . DB_NAME . ";", DB_USER, DB_PASS);  
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {  
                echo "Erro ao tentar conectar no banco de dados: " . $e->getMessage();  
            }  
        }

        return self::$pdo;  
    }
}