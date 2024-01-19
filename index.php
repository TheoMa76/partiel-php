<?php
require_once "./configs/dbConnect.php";
require_once "./src/crud/crud.php";
require_once "./src/outils/toolkit.php";
include "./templates/includes/menu.inc.php";

debugMode(true);

if(isset($_GET['page']) && $_GET['page'] === 'accueil') {
    include './templates/accueil/accueil.php';
}

if(isset($_GET['page']) && $_GET['page'] === 'listquestions') {
        include './templates/listquestions/questions.php';
}

if(isset($_GET['page']) && $_GET['page'] === 'test') {
    include './templates/reponse/test.php';
}

if(!isset($_GET['page'])) {
    include './templates/accueil/accueil.php';
}
