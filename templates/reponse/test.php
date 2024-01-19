<?php
use Theo\Entity\Question;
use Theo\Entity\Reponse;
use Theo\Repository\QuestionRepository;
use Theo\Repository\ReponseRepository;

require_once "./templates/includes/layoutGeneral.inc.php";
require_once "./src/Repository/ReponseRepository.php";
require_once "./src/crud/crud.php";
require_once "./configs/dbConnect.php";
require_once "./src/Repository/QuestionRepository.php";
require_once "./src/Entity/Reponse.php";

$repo = new QuestionRepository();
$repoReponse = new ReponseRepository();

if(isset($_POST['repondre'])) {

    $reponse = $_POST["reponse"];
    $questionID = $_POST["questionID"];

    $objQuestionAffichee = $repo->findById($questionID);

    $rep = new Reponse($questionID, $reponse);
    create($rep);

    if($reponse == $objQuestionAffichee->getReponseJuste()){
        $message = "<div class='alert alert-success text-center' role='alert'>Bonne réponse !</div>";
        $message .= '<a href="http://localhost/partiel-php/?page=accueil" class="btn btn-primary">Retourner aux questions</a>';

    }else{
        $message = "<div class='alert alert-danger text-center' role='alert'>Mauvaise réponse !</div>";
        $message .= '<a href="http://localhost/partiel-php/?page=accueil&questionID='. $_POST["questionID"] .'" class="btn btn-primary">Retourner à cette question</a>';
        $message .= '<a href="http://localhost/partiel-php/?page=accueil" class="btn btn-primary">Retourner aux questions aléatoires</a>';

    }
    $allrep = $repoReponse->findAll();
    $nombretotalrep = 0;
    $nombregoodrep = 0;
    foreach($allrep as $r){
        if($r->getIdQuestion() == $questionID){
            $nombretotalrep++;
        }
    }
    foreach($allrep as $r){
        if($r->getIdQuestion() == $questionID && $r->getReponse() == $objQuestionAffichee->getReponseJuste()){
            $nombregoodrep++;
        }
    }
    $pourcentage = ($nombregoodrep/$nombretotalrep)*100;
    $objQuestionAffichee->setReussite($pourcentage);
    update($objQuestionAffichee,$questionID);
}
if(isset($message)) {
    echo $message;
}