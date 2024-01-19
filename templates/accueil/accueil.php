<?php
use Theo\Entity\Question;
use Theo\Entity\Reponse;
use Theo\Repository\QuestionRepository;

require_once "./templates/includes/layoutGeneral.inc.php";
require_once "./src/crud/crud.php";
require_once "./configs/dbConnect.php";
require_once "./src/Repository/QuestionRepository.php";

$repo = new QuestionRepository();

$questions = $repo->findAll();

if($questions == null){
    echo "<div class='alert alert-danger text-center' role='alert'>Il n'y a pas de questions dans la base de données !</div>";
    echo '<a href="http://localhost/partiel-php/?page=listquestions" class="btn btn-primary">Créer une question</a>';
    exit();
}

if(isset($_GET['questionID'])){
    $index = $_GET['questionID'];
    $questionAffichee = $repo->findById($index);
    $objQuestionAffichee = new Question($questionAffichee->getTitre(), $questionAffichee->getPartageurl(), $questionAffichee->getReponseJuste(), $questionAffichee->getMessageSuccess(), $questionAffichee->getMessageError(), $questionAffichee->getReussite());
    $objQuestionAffichee->setId($questionAffichee->getId());
}else{
    $index = random_int(0, count($questions)-1);
    $questionAffichee = $questions[$index];
    $objQuestionAffichee = new Question($questionAffichee->getTitre(), $questionAffichee->getPartageurl(), $questionAffichee->getReponseJuste(), $questionAffichee->getMessageSuccess(), $questionAffichee->getMessageError(), $questionAffichee->getReussite());
    $objQuestionAffichee->setId($questionAffichee->getId());
}

?>

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card text-white bg-dark" style="width: 50%;">
        <div class="card-body">
            <h3 class="card-title">Question :</h3>
            <p class="card-text"><?= $questionAffichee->getTitre() ?></p>
            <p class="card-text">Pourcentage de réussite : <?= $questionAffichee->getReussite() ?> %</p>
            <form method="post" action="?page=test">
                <div class="form-group">
                    <input type="hidden" name="questionID" value="<?= $questionAffichee->getId() ?>">
                </div>
                <div class="form-group">
                    <h3 class="card-title">Réponse :</h3>
                    <input type="text" name="reponse" id="reponse" class="form-control mb-3">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary" name="repondre">Répondre</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php

