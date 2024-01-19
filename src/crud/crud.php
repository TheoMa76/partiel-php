<?php 
require_once "./configs/dbConnect.php";

function queryBuilder($method, $table, ...$payload){
    $query ="";
    switch ($method) {
        case 'c':
            $query .= "INSERT INTO ";
            break;
        case 'r':
            $query .= "SELECT * FROM ";
            break;
        case 'u':
            $query .= "UPDATE ";
            break;
        case 'd':
            $query .= "DELETE FROM ";
            break;
        default:
           
            die("ERROR : Prepared query method not defined");
    }

    $query .= '`'.  htmlspecialchars($table) . '` ';
    if($method ==='u'){
        $query .= "SET ";


    }
    if ($method === "c") {
        $columns = [];
        $values = [];
    
        foreach ($payload as $index => $column) {
            foreach ($column as $key => $value) {
                $columns[] = "`" . $key . "`";
                if (is_string($value)) {
                    $value = "'" . $value . "'";
                }
                $values[] = $value;
            }
        }
    
        $columnString = implode(", ", $columns);
        $valueString = implode(", ", $values);
        $query .= "($columnString) VALUES ($valueString)";
    }
    
    
    if($method ==='u'){
        foreach ($payload as $index => $filter) {
            foreach ($filter as $key => $value) {
                if($key !== "id"){
                    if(is_string($value)){
                        $value = "\"" . $value. "\"";
                    }
                    
                    $queryParts[] = "`" . $key . "` = ". $value;                    
                }
            }
        }
        $query .= implode(", ", $queryParts);
    }
    if($method !=='c' && $method !== "u" && count($payload)){
        $query .= "WHERE ";
        foreach ($payload as $index => $filter) {
            foreach ($filter as $key => $value) {
                if(is_string($value)){
                    $value = "\"" . $value. "\"";
                }
                $query .= "`" . $key . "` = ". $value; 
            }
        }
    } else if($method === "u"){
        $idFound = false;
        foreach ($payload as $index => $filter) {
            foreach ($filter as $key => $value) {
                if($key === "id"){
                    $idFound = true;
                
                    $query .= " WHERE ";
                    $query .= "`" . $key . "` = ". $value;
                } 
            }
        }
        if(!$idFound){
            die("ERROR : Not id to update");
        }
    }
    
   return $query;

}


/*fonction create qui prend en paremetre n'importe quel objet , récupère ses attributs et détermine
le nom de la table en fonction du nom de la class ( class : Etudiant -> nom table : etudiant )*/

function create(Object $object){
    $attributs = [];
    $reflectionClass = new ReflectionClass($object);
    $proprietes = $reflectionClass->getProperties(ReflectionProperty::IS_PROTECTED);
    $nomClass = $reflectionClass->getShortName();
    $nomTable = strtolower($nomClass);
    
    foreach($proprietes as $propriete){
        $nomPropriete = $propriete->getName();
        $propriete->setAccessible(true);
        $attributs[$nomPropriete] = $propriete->getValue($object);
    }
    $query = queryBuilder('c',$nomTable, $attributs);
    $connection = new PDOManagerClass();
    try {
        $statement = $connection->prepare($query);
        $statement->execute();
        echo "Succès !";
    } catch(PDOException $e) {
        echo $query . "<br>" . $e->getMessage();
    }
}

/*fonction update qui prend en paremetre n'importe quel objet , récupère ses attributs et détermine
le nom de la table en fonction du nom de la class ( class : Etudiant -> nom table : etudiant )*/
function update(Object $object, int $id){
    $attributs = [];
    $reflectionClass = new ReflectionClass($object);
    $proprietes = $reflectionClass->getProperties(ReflectionProperty::IS_PROTECTED);
    $nomClass = $reflectionClass->getShortName();
    $nomTable = strtolower($nomClass);
    
    foreach($proprietes as $propriete){
        $nomPropriete = $propriete->getName();
        $propriete->setAccessible(true);
        $attributs[$nomPropriete] = $propriete->getValue($object);
    }

    $query = queryBuilder('u', $nomTable, $attributs, ["id" => $id]);

    $connection = new PDOManagerClass();
    try {
        $statement = $connection->prepare($query);
        $statement->execute();
        echo "L'objet a été mis à jour avec succès.";
    } catch(PDOException $e) {
        echo $query . "<br>" . $e->getMessage();
    }
}

function delete(Object $object, int $id){
    $attributs = [];
    $reflectionClass = new ReflectionClass($object);
    $proprietes = $reflectionClass->getProperties(ReflectionProperty::IS_PROTECTED);
    $nomClass = $reflectionClass->getShortName();
    $nomTable = strtolower($nomClass);
    
    $query = queryBuilder('d', $nomTable, ["id" => $id]);

    $connection = new PDOManagerClass();
    try {
        $statement = $connection->prepare($query);
        $statement->execute();
        echo "L'objet a été supprimé avec succès.";
    } catch(PDOException $e) {
        echo $query . "<br>" . $e->getMessage();
    }
}

function read(string $table){

    $query = queryBuilder('r', $table);
    $connection = new PDOManagerClass();
    try {
        $statement = $connection->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    } catch(PDOException $e) {
        echo $query . "<br>" . $e->getMessage();
    }
}

function getQueryRead(string $table){
    $query = queryBuilder('r', $table);
    return $query;
}




