<?php
namespace Theo\Repository;

use PDOManagerClass;
use Theo\Entity\Reponse;

require_once "./src/Entity/Reponse.php";
require_once "./src/crud/crud.php";
require_once "./configs/dbConnect.php";

class ReponseRepository{
    public function findAll(){
        $result = read("reponse");
        if(!empty($result)){
            $reponses = [];
            foreach($result as $reponse){
                $r = new Reponse($reponse['idQuestion'], $reponse['reponse']);
                $r->setId($reponse['id']);
                $reponses[] = $r;
            }
            return $reponses;
        }
    }
}