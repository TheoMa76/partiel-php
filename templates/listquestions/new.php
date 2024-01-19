<?php
use Theo\Entity\Question;
use Theo\Repository\QuestionRepository;

require_once "./templates/includes/layoutGeneral.inc.php";
require_once "./src/crud/crud.php";
require_once "./src/Entity/Question.php";
require_once "./src/Repository/QuestionRepository.php";

$repo = new QuestionRepository();

function generateRandomFileName($originalFileName)
{
    $extension = pathinfo($originalFileName, PATHINFO_EXTENSION);
    $randomFileName = md5(uniqid(rand(), true)) . '.' . $extension;
    return $randomFileName;
}

if(isset($_POST['createQuestionBtn'])) {

    $titre = $_POST["titre"];
    $partageurl = $_POST["partageurl"];
    $reponse = $_POST["reponse"];
    $success = $_POST["success"];
    $error = $_POST["error"];

    $newQuestion = new Question($titre, $partageurl,$reponse,$success,$error,0);

    create($newQuestion);
    $temp = $repo->findByQuestion($newQuestion->getTitre());
    $id = $temp->getId();
    $newQuestion->setId($id);
    $newQuestion->setPartageurl($partageurl.$id);
    update($newQuestion,$id);
}
?>
<div class="container">
  <h5>Créer une question</h5>
  <form method="post" action="" enctype="multipart/form-data">
      <div class="form-group">
          <label for="titre">Question :</label>
          <input type="text" class="form-control" id="titre" name="titre" required>
      </div>
      <div class="form-group">
          <input type="hidden" class="form-control" id="partageurl" name="partageurl" value="http://localhost/partiel-php/?page=accueil&questionID="required>
      </div>

      <div class="form-group">
          <label for="reponse">Réponse :</label>
          <input type="text" class="form-control" id="reponse" name="reponse" required>
      </div>

        <div class="form-group">
            <label for="success">Message de réussite :</label>
            <input type="text" class="form-control" id="success" name="success" required>
        </div>

        <div class="form-group">
            <label for="error">Message d'erreur :</label>
            <input type="text" class="form-control" id="error" name="error" required>
        </div>

      <div class="form-group text-center">
        <button type="submit" class="btn btn-primary" name="createQuestionBtn">Créer</button>
      </div>
      </form>
</div>
