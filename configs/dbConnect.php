<?php

    class PDOManagerClass extends PDO {

        private $host;
        private $username;
        private $password;
        private $port;
        private $db_name;
        private $pdo;
    
        public function __construct() {
                $configFile = file_get_contents('configs/config.json');
                $configData = json_decode($configFile, true);
        
                if ($configData === null) {
                    throw new Exception("Error decoding JSON from config file.");
                }
        
                $this->host = $configData['database']['host'];
                $this->username = $configData['database']['user'];
                $this->password = $configData['database']['password'];
                $this->port = $configData['database']['port'];
                $this->db_name = $configData['database']['db_name'];
                $dsn ="mysql:host=".$this->host.";dbname=".$this->db_name;
                parent::__construct($dsn, $this->username, $this->password);
                try {
                    $this->pdo = new PDO($dsn, $this->username, $this->password);
                    $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                } catch (PDOException $e) {
                    die("Erreur de connexion : " . $e->getMessage());
                }
                //$this->connect();            
            }
        public function findAll(array $table): array {
            try {
                $data[] = [];
                $query = "SELECT * FROM $table[0]";
                $statement = $this->pdo->prepare($query);
                $statement->execute();
                $data = $statement->fetchAll(PDO::FETCH_ASSOC);
                return $data;
            } catch (PDOException $e) {
                die("Erreur lors de la récupération des données : " . $e->getMessage());
            }
        }

        public function findBy(array $table, string $condition): array{
            try{
                $data[] = [];
                $query = "SELECT * FROM $table[0] WHERE";
                $query .=" $condition";

                $statement = $this->pdo->prepare($query);
                $statement->execute();
                $data = $statement->fetchAll(PDO::FETCH_ASSOC);
                return $data;
            } catch (PDOException $e){
                die("Erreur lors de la récupération des données : ".$e->getMessage());
            }
        }

        public function getRelation(array $table , string $condition, string $condColonnes = "", array $select = ["*"]){
            try{
                $query = "SELECT";
                $last = array_key_last($select);
                foreach ($select as $key => $sel) {
                    $query .= " $sel";
                    if ($key !== $last) {
                        $query .= ',';
                    }
                }
                $query.=" FROM $table[0]";
                for($i=1 ; $i<count($table) ; $i++){
                    $query .=" INNER JOIN $table[$i] ON";
                }
                $query.=" $condColonnes";
                $query.=" WHERE $condition ";
                $statement = $this->pdo->prepare($query);
                $statement->execute();
                $data = $statement->fetchAll(PDO::FETCH_ASSOC);
                return $data;
            }catch (PDOException $e){
                    die("Erreur lors de la récupération des données : ".$e->getMessage());
                }
        }

        public function getPdo():PDO{
            return $this->pdo;
        }

        public function setPdo(PDO $pdo):void{
            $this->pdo = $pdo;
        }

        public function getDbName():string{
            return $this->db_name;
        }

        public function setDbName(string $db_name):void{
            $this->db_name = $db_name;
        }
    }