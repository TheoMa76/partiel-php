<?php
use Theo\Entity\Produits;

require_once "./templates/includes/layoutGeneral.inc.php";
require_once "./src/crud/crud.php";
require_once "./src/Entity/Produits.php";
require_once "./src/Repository/ProduitsRepository.php";

use Theo\Repository\ProduitsRepository;

$produitID = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : '';
$repository = new ProduitsRepository();

function generateRandomFileName($originalFileName)
{
    $extension = pathinfo($originalFileName, PATHINFO_EXTENSION);
    $randomFileName = md5(uniqid(rand(), true)) . '.' . $extension;
    return $randomFileName;
}

if(isset($produitID) && !empty($produitID)){
    $produit = $repository->findById($produitID);
}

if(isset($_POST['editProduitBtn'])) {

    $nom = $_POST["nom"];
    $shortDesc = $_POST["shortDesc"];
    $description = $_POST["description"];
    $prix = $_POST["prix"];
    $quantite = $_POST["quantite"];
    $enAvant = isset($_POST["enAvant"]) ? 1 : 0;

    $produit->setNom($nom);
    $produit->setShortDesc($shortDesc);
    $produit->setDescription($description);
    $produit->setprix($prix);
    $produit->setQuantite($quantite);
    $produit->setEnAvant($enAvant);
    $imageFileName = '';
    $destinationPath = $produit->getImage();

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imageFileName = generateRandomFileName($_FILES['image']['name']);
        $destinationPath = './public/img/' . $imageFileName;
        move_uploaded_file($_FILES['image']['tmp_name'], $destinationPath);
        $produit->setImage($destinationPath);
    }

    update($produit, $produitID);
    echo '<script>window.location.href = "index.php?page=admin&sous-page=produit";</script>';
}

?>

        <h5>Modifier un produit</h5>
      <div class="container mt-5">
        <form method="post" action="" enctype="multipart/form-data">
            <div class="form-group">
                    <label for="nom">Nom :</label>
                    <input type="text" class="form-control" id="nom" name="nom" value="<?php echo $produit->getNom(); ?>" required>
                </div>

                    <div class="form-group">
                        <label for="image">Image :</label>
                        <input type="file" class="form-control-file" id="image" name="image" value="<?php echo $destinationPath ?>">
                    </div>

                <div class="form-group">
                    <label for="shortDesc">Description courte :</label>
                    <input type="text" class="form-control" id="shortDesc" name="shortDesc" value="<?php echo $produit->getShortDesc(); ?>" required>
                </div>

                <div class="form-group">
                    <label for="description">Description :</label>
                    <textarea class="form-control" id="description" name="description" rows="3" required><?php echo $produit->getDescription(); ?></textarea>
                </div>

                <div class="form-group">
                    <label for="prix">Prix :</label>
                    <input type="number" class="form-control" id="prix" name="prix" step="0.5" value="<?php echo $produit->getPrix(); ?>" required>
                </div>

                <div class="form-group">
                    <label for="quantite">Quantité :</label>
                    <input type="number" class="form-control" id="quantite" name="quantite" value="<?php echo $produit->getQuantite(); ?>" required>
                </div>

                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="enAvant" name="enAvant" <?php echo ($produit->getEnAvant() == 1) ? 'checked' : ''; ?>>
                        <label class="custom-control-label" for="enAvant">Mettre en avant</label>
                    </div>
                </div>
                        <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary" name="editProduitBtn">Éditer</button>
                    </div>
            </form>
        </div>