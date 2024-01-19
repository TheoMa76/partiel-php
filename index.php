<?php
require_once "./configs/dbConnect.php";
require_once "./src/crud/crud.php";
require_once "./src/outils/toolkit.php";
include "./templates/includes/menu.inc.php";

if(isset($_GET['page']) && $_GET['page'] === 'accueil') {
    include './templates/accueil/accueil.php';
}

if(isset($_GET['page']) && $_GET['page'] === 'catalogue') {
        include './templates/listquestions/questions.php';
}

if(!isset($_GET['page'])) {
    include './templates/accueil/accueil.php';
}
