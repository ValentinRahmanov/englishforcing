<?php

class DB
{
    public static $conn;
    
    public static function init()
    {
        $dbhost = $_ENV['config']['db']['dbhost'];
        $user = $_ENV['config']['db']['dbusername'];
        $pass = $_ENV['config']['db']['dbpassword'];
        
        try {
            $conn = mysqli_connect($dbhost, $user, $pass, 'f90577wq_plants');
            self::$conn = $conn;
        } catch (PDOException $e) {
            die("Connection failed: " . mysqli_connect_error());
            echo $e;
        }
    }

    public static function query($queryString)
    {
        print_r($queryString);
        if (strpos($queryString, 'INSERT') !== false) {
        mysqli_query(self::$conn, $queryString);
        }
        
        if (strpos($queryString, 'SELECT') !== false) {
        $result = self::$conn->query($queryString);
        
        return $result;
        }

        if (strpos($queryString, 'DELETE') !== false) {
//            $result = self::$conn->query($queryString);

            print_r($queryString);
            self::$conn->query($queryString);
        }

    }

    public static function close()
    {
        self::$conn = null;
    }

}

DB::init();