<?php

namespace BITM\SEIP12;

class Config{

    static public  $driver = 'mysql';

    const   DB_HOST = 'localhost';         
    const   DB_USER = 'root';         
    const   DB_PASSWORD = '';         
    const   DB_NAME = 'eshop'; 

    static public function datasource(){

        return self::docroot()."datasource".DIRECTORY_SEPARATOR;

    }

    static public function docroot(){
        
        return $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR;
    }


}

