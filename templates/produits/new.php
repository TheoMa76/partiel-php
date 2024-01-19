<?php
use Theo\Entity\Produits;

require_once "./templates/includes/layoutGeneral.inc.php";
require_once "./src/crud/crud.php";
require_once "./src/Entity/Produits.php";

function generateRandomFileName($originalFileName)
{
    $extension = pathinfo($originalFileName, PATHINFO_EXTENSION);
    $randomFileName = md5(uniqid(rand(), true)) . '.' . $extension;
    return $randomFileName;
}

if(isset($_POST['createProduitBtn'])) {

    $nom = $_POST["nom"];
    $shortDesc = $_POST["shortDesc"];
    $description = $_POST["description"];
    $prix = $_POST["prix"];
    $quantite = $_POST["quantite"];
    $enAvant = isset($_POST["enAvant"]) ? 1 : 0;

    $nouveauProduit = new Produits($nom, $shortDesc, $description, $prix, $quantite, $enAvant);

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
      $imageFileName = generateRandomFileName($_FILES['image']['name']);
      $destinationPath = './public/img/' . $imageFileName;
      move_uploaded_file($_FILES['image']['tmp_name'], $destinationPath);
      $image = $imageFileName;
      $nouveauProduit->setImage($destinationPath);
  }

    


    create($nouveauProduit);
    echo "Produit créé avec succès !";
}
?>

<div class="modal fade" id="createProduitModal" tabindex="-1" role="dialog" aria-labelledby="createProduitModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createProduitModalLabel">Créer un produit</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="" enctype="multipart/form-data">
            <div class="form-group">
                    <label for="nom">Nom :</label>
                    <input type="text" class="form-control" id="nom" name="nom" required>
                </div>
                
                <div class="form-group">
                        <label for="image">Image :</label>
                        <input type="file" class="form-control-file" id="image" name="image">
                    </div>

                <div class="form-group">
                    <label for="shortDesc">Description courte :</label>
                    <input type="text" class="form-control" id="shortDesc" name="shortDesc" required>
                </div>

                <div class="form-group">
                    <label for="description">Description :</label>
                    <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                </div>

                <div class="form-group">
                    <label for="prix">Prix :</label>
                    <input type="number" class="form-control" id="prix" name="prix" step="0.01" required>
                </div>

                <div class="form-group">
                    <label for="quantite">Quantité :</label>
                    <input type="number" class="form-control" id="quantite" name="quantite" required>
                </div>

                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="enAvant" name="enAvant">
                        <label class="custom-control-label" for="enAvant">Mettre en avant</label>
                    </div>
                </div>
                        <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary" name="createProduitBtn">Créer</button>
                    </div>
            </form>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>