<?php
class connectionClass {
    private $host = "127.0.0.1";
    private $port = "80";
    private $user = "root";
    private $pass = "";
    private $db = "example_workshop";
    private $charset = "utf8";
    private $conn;

    function __construct() {
        $this->conn = $this->connectDB();
    }

    function connectDB() {
        $conn = mysqli_connect($this->host, $this->user, $this->pass, $this->db);
        return $conn;
    }

    function pdo() {
        $pdo = new PDO(
            "mysql:host=$this->host;dbname=$this->db;charset=$this->charset", $this->user, $this->pass,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_NAMED
            ]
        );
        return $pdo;
    }

    function runBaseQuery($query, $mode) {
        $result = $this->pdo()->prepare($query);
        $result->execute();
        if($result->rowCount() > 0){
            switch ($mode){
                case 'while':
                    while($row = $result->fetch()){
                        $resultSet[] = $row;
                    }
                    break;
                case 'if':
                    if($row = $result->fetch()){
                        $resultSet[] = $row;
                    }
                    break;
            }
        }
        return $resultSet;
    }

    function runQuery($query, $param, $mode){
        $paramEx = explode('#', implode('#', $param));
        $result = $this->pdo()->prepare($query);
        $result->execute($paramEx);
        if($result->rowCount() > 0){
            switch ($mode){
                case 'while':
                    while($row = $result->fetch()){
                        $resultSet[] = $row;
                    }
                    break;
                case 'if':
                    if($row = $result->fetch()){
                        $resultSet[] = $row;
                    }
                    break;
            }
        }
        return $resultSet;
    }

    function opQuery($query, $param, $notification){
        $paramEx = explode('#', implode('#', $param));
        $notifEx = explode('#', $notification);
        $operation = $this->pdo()->prepare($query);
        if($operation->execute($paramEx) == TRUE) {
            switch ($notifEx[0]){
                case '0':
                    break;
                case '1':
                    echo "
                        <script>
                            window.alert('".$notification."');
                        </script>
                    ";
                    break;
            }
        }
        return true;
    }

    function countQuery($query){
        $result = $this->pdo()->prepare($query);
        $result->execute();
        if($row = $result->fetch()) {
            $resultSet = $row['total'];
        }
        return $resultSet;
    }
}