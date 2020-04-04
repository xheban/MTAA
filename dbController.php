<?php

$kokot = 5;
class ConnectDb
{
    // Hold the class instance.
    private static $instance = null;
    private $conn;

    private $host = 'localhost';
    private $user = 'root';
    private $pass = '';
    private $dbName = 'mtaa';

    // The db connection is established in the private constructor.
    private function __construct()
    {
        $this->conn = mysqli_connect($this->host, $this->user, $this->pass, $this->dbName);
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new ConnectDb();
        }

        return self::$instance;
    }

    public function getConnection()
    {
        return $this->conn;
    }
}

?>
