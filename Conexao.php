<?php

require_once ".env.php";

class Conexao{

    private static $instance;

    public static function getInstance(){
        if (self::$instance == null){
            self::$instance = new PDO(DRIVER.":host=".HOST.";dbname=".DB_NAME, USER, PASSWORD);
            self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$instance;
    }

}