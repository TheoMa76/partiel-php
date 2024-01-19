<?php
use Theo\Repository\UsersRepository;

require_once "./templates/includes/layoutGeneral.inc.php";
require_once "./templates/includes/adminmenu.inc.php";
require_once "./src/crud/crud.php";
require_once "./configs/dbConnect.php";
require_once "./src/Repository/ProduitsRepository.php";

include "./templates/produits/new.php";

use Theo\Repository\ProduitsRepository;
use Theo\Entity\Produits;

$repository = new ProduitsRepository();
$produits = $repository->findAll();

$redirectNeeded = false;

if (isset($_POST['action']) && $_POST['action'] === 'delete') {
    $id = $_POST['id'];
    $produit = $repository->findById($id);
    delete($produit, $id);
    $redirectNeeded = true;
}


?>

<title>Liste des produits</title>

<style>
    .custom-img-thumbnail {
        width: 100px; 
        height: auto;
    }
</style>

<div class="container">
        <h1>Liste des produits</h1>

        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createProduitModal">
            Créer un produit
        </button>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Image</th>
                        <th>Description courte</th>
                        <th>Description</th>
                        <th>Prix</th>
                        <th>Quantite</th>
                        <th>Mis en avant</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    if ($produits != null && count($produits) > 0) {
                        for ($i = 0; $i < count($produits); $i++) {
                            echo "<tr>";
                            echo "<td>" . $produits[$i]->getId() . "</td>";
                            echo "<td>" . $produits[$i]->getNom() . "</td>";
                            echo "<td><img src='" . $produits[$i]->getImage() . "' class='custom-img-thumbnail'></img></td>";
                            echo "<td>" . $produits[$i]->getShortDesc() . "</td>";
                            echo "<td>" . $produits[$i]->getDescription() . "</td>";
                            echo "<td>" . $produits[$i]->getPrix() . "</td>";
                            echo "<td>" . $produits[$i]->getQuantite() . "</td>";
                            echo $produits[$i]->getEnAvant() == 1 ? "<td>Oui</td>" : "<td>Non</td>";

                            // Boutons d'action
                            echo "<td>";
                            echo "<a href='./?page=admin&sous-page=produit&action=edit&id=" . $produits[$i]->getId() . "' class='btn btn-primary edit-button'>Editer</a>";
                            echo "<form method='post' action=''>";
                            echo "<input type='hidden' name='action' value='delete'>";
                            echo "<input type='hidden' name='id' value='" . $produits[$i]->getId() . "'>";
                            echo "<button type='submit' name='submit' class='btn btn-danger' onclick=\"return confirm('Voulez-vous vraiment supprimer ce produit ?')\">Supprimer</button>";
                            echo "</form>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='9' class='alert alert-info'>Aucun produit trouvé. Vous pouvez en créer ici !</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    


<?php
if (isset($_POST['action']) && $_POST['action'] === 'delete') {
    $id = $_POST['id'];
    delete($produit, $id);
}

if ($redirectNeeded) {
    echo '<script>window.location.href = "index.php?page=admin&sous-page=produit";</script>';
    exit();
}
?>