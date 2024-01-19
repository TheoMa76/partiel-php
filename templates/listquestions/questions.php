<?php
use Theo\Entity\Question;
use Theo\Repository\QuestionRepository;

require_once "./templates/includes/layoutGeneral.inc.php";
require_once "./src/crud/crud.php";
require_once "./configs/dbConnect.php";
require_once "./src/Repository/QuestionRepository.php";

include "./templates/listquestions/new.php";

$repository = new QuestionRepository();

if(isset($_GET["order"]) && $_GET["order"]=="DESC"){
    $questions = $repository->findAllSortedBySuccess("DESC");
}else if(isset($_GET["order"]) && $_GET["order"]=="ASC"){
    $questions = $repository->findAllSortedBySuccess("ASC");
}
else{
    $questions = $repository->findAll();
}

$redirectNeeded = false;

if (isset($_POST['action']) && $_POST['action'] === 'delete') {
    $id = $_POST['id'];
    $question = $repository->findById($id);
    delete($question, $id);
    $redirectNeeded = true;
}
function handleSortRequest($order) {
    $existingParams = $_GET;
    if (isset($existingParams['order'])) {
        unset($existingParams['order']);
    }
    $existingParams['order'] = $order;
    
    $queryString = http_build_query($existingParams);
    $url = $_SERVER['PHP_SELF'] . '?' . $queryString;
    
    $redirectNeeded = true;
}


?>

<title>Liste des questions</title>

<style>
    .custom-img-thumbnail {
        width: 100px; 
        height: auto;
    }
</style>

<div class="container">
    <div class="row text-center">
        <div class="col-md-6">
            <a href="http://localhost/partiel-php/?page=listquestions&order=ASC">
                <button type="button" class="btn btn-primary">Trier par réussite croissante</button>
            </a>
        </div>
        <div class="col-md-6">
            <a href="http://localhost/partiel-php/?page=listquestions&order=DESC">
                <button type="button" class="btn btn-primary">Trier par réussite décroissante</button>
            </a>
        </div>
    </div>

        <h1>Liste des questions</h1>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Question</th>
                        <th>Lien de partage</th>
                        <th>Réponse attendue</th>
                        <th>Reussite</th>
                        <th>Message reussite</th>
                        <th>Message erreur</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    if ($questions != null && count($questions) > 0) {
                        for ($i = 0; $i < count($questions); $i++) {

                            echo "<tr>";
                            echo "<td>" . $questions[$i]->getId() . "</td>";
                            echo "<td>" . $questions[$i]->getTitre() . "</td>";
                            echo "<td><a href='" . $questions[$i]->getPartageurl() . "'>" . $questions[$i]->getPartageurl() . "</a></td>";
                            echo "<td>" . $questions[$i]->getReponseJuste() . "</td>";
                            echo "<td>" . $questions[$i]->getMessageSuccess() . "</td>";
                            echo "<td>" . $questions[$i]->getMessageError() . "</td>";
                            echo "<td>" . intval($questions[$i]->getReussite()) . " %</td>";

                            // Boutons d'action
                            echo "<td>";
                            echo "<form method='post' action=''>";
                            echo "<input type='hidden' name='action' value='delete'>";
                            echo "<input type='hidden' name='id' value='" . $questions[$i]->getId() . "'>";
                            echo "<button type='submit' name='submit' class='btn btn-danger'>Supprimer</button>";
                            echo "</form>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='9' class='alert alert-info'>Aucune question trouvée. Vous pouvez en créer ici !</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    


<?php
if (isset($_POST['action'])) {
    if ($_POST['action'] === 'delete') {
        $id = $_POST['id'];
        delete($question, $id);
        $redirectNeeded = true;
    } elseif ($_POST['action'] === 'sort_by_success_desc') {
        handleSortRequest('desc');
        $redirectNeeded = true;

    }
    elseif ($_POST['action'] === 'sort_by_success_asc') {
        handleSortRequest('asc');
        $redirectNeeded = true;

    }
}

if ($redirectNeeded) {
    header("Location: ?page=listquestions");
    $redirectNeeded = false;
    exit();
}
?>