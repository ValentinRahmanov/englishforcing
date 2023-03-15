<?php

namespace Model;

use Controller\DbErrorsController;

class DB
{
    private $dbconn;

    private static function getDbData()
    {
        return json_decode(file_get_contents(__DIR__ . "../../config.json"), true);
    }

    public function init()
    {
        $host = $this->getDbData()['db']['dbhost'];
        $db = $this->getDbData()['db']['dbname'];
        $user = $this->getDbData()['db']['dbusername'];
        $pass = $this->getDbData()['db']['dbpassword'];

        try {
            $this->dbconn = pg_connect("host=$host dbname=$db user=$user password=$pass");

        } catch (\Exception $e) {
            die('Подключение не удалось: ' . $e->getMessage());
        }
    }

    public function query($queryString)
    {
        try {
            if (strpos($queryString, 'SELECT') !== false && strpos($queryString, 'hierarchy') !== false) {
                $result = pg_query($this->dbconn, $queryString);
                while ($row = pg_fetch_row($result)) {
                    $category_table[] = $row;
                }
                return $category_table;
            } elseif (strpos($queryString, 'SELECT') !== false && strpos($queryString, 'objects') !== false) {
                $result = pg_query($this->dbconn, $queryString);
                while ($row = pg_fetch_row($result)) {
                    $objects_table[] = $row;
                }
                return $objects_table;
            }

            if (strpos($queryString, 'INSERT') !== false) {
                pg_query($this->dbconn, $queryString);
            }

            if (strpos($queryString, 'UPDATE') !== false) {
                pg_query($this->dbconn, $queryString);
            }

            if (strpos($queryString, 'DELETE') !== false) {
                pg_query($this->dbconn, $queryString);
            }
        } catch (\DbErrorsController $e) {
            DbErrorsController::serviceDbErrors($e->getMessage(), $e->getCode());
        }
    }

    public function close()
    {
        $this->dbconn = null;
    }

}

