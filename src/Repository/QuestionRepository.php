<?php
namespace Theo\Repository;

use PDOManagerClass;
use Theo\Entity\Question;

require_once "./src/Entity/Question.php";
require_once "./src/crud/crud.php";
require_once "./configs/dbConnect.php";

class QuestionRepository{
    public function findAll(){
        $result = read("question");
        if(!empty($result)){
            $questions = [];
            foreach($result as $question){
                $q = new Question($question['titre'], $question['partageurl'],$question['reponseJuste'],$question['messageSuccess'],$question['messageError'] ,$question['reussite']);
                $q->setId($question['id']);
                $questions[] = $q;
            }
            return $questions;
        }
    }

    public function findByQuestion($titre){
        $result = read("question");
        if(!empty($result)){
            foreach($result as $question){
                if($question['titre'] === $titre){
                    $q = new Question($question['titre'], $question['partageurl'],$question['reponseJuste'],$question['messageSuccess'],$question['messageError'], $question['reussite']);
                    $q->setId($question['id']);
                    return $q;
                }
            }
        }
    }

    public function findAllSortedBySuccess($order) {        
        $result = read("question",true,$order);

        if (!empty($result)) {
            $questions = [];
            foreach ($result as $question) {
                $q = new Question($question['titre'], $question['partageurl'], $question['reponseJuste'],$question['messageSuccess'],$question['messageError'], $question['reussite']);
                $q->setId($question['id']);
                $questions[] = $q;
            }
            return $questions;
        }
    }

    public function findById(int $id){
        $result = read("question");
        if(!empty($result)){
            foreach($result as $question){
                if($question['id'] === $id){
                    $q = new Question($question['titre'], $question['partageurl'],$question['reponseJuste'],$question['messageSuccess'],$question['messageError'], $question['reussite']);
                    $q->setId($question['id']);
                    return $q;
                }
            }
        }
    }
}