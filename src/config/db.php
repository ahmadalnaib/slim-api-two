<?php

class DB {
    private $dbhost = '127.0.0.1';  
    private $dbuser='root';
    private $dbpass=null;
    private $dbname='slim';
    private $dbport='3301';

    public function connectDB(){
        $mysql_connect_str = "mysql:host=$this->dbhost;dbname=$this->dbname;port=$this->dbport";
        $dbConnection = new PDO($mysql_connect_str, $this->dbuser, $this->dbpass);
        $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $dbConnection;
    }


}


