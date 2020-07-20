<?php

class DB{

    private static $pdo = null;

    public function __construct(){

    }

   public static function connect(){
        //$host     = 'localhost';
        $host     = '34.70.183.119';
        $db       = 'u716496248_alvar';
        $user     = 'u716496248_alvar';
        $password = "alvaro";

        if(self::$pdo == null){
            try{

                $connection = "mysql:host=" . $host . ";dbname=" . $db.";port=3306" ;
                self::$pdo = new PDO($connection, $user, $password,array( // options
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                ));

            }catch(PDOException $e){
                print_r('Error connection: ' . $e->getMessage());
            }
        }

        return self::$pdo;

    }
}






?>
