<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'config.php';
include 'Utils.php';

$utils = new Utils();

if (!$utils->checkCookie('token_admin')) {
    header('Location: login.php?error=disconnected');
}

if (isset($_POST['submit'])) {
    $req = $db->prepare('UPDATE lessons_chapters SET name = :name, description = :description WHERE ID = :id');
    $req->execute(array(
            'name' => htmlspecialchars($_POST['title']),
            'description' => htmlspecialchars($_POST['description']),
            'id' => htmlspecialchars($_GET['id'])
    ));
    header('Location: chapters');
}

$req = $db->prepare('SELECT * FROM lessons_chapters WHERE ID = :id');
$req->execute(array('id' => htmlspecialchars($_GET['id'])));
$chapter = $req->fetch();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Eloquéncia est une association loi 1901 visant à promouvoir l'éloquence et l'art oratoire">
    <meta name="keywords" content="éloquence, oratoire, association, loi 1901, parler en public, discours, formation, cours en ligne">
    <meta name="author" content="Eloquéncia">
    <meta name="robots" content="index, follow">
    <meta name="revisit-after" content="7 days">
    <meta name="language" content="fr">
    <meta property="og:site_name" content="Eloquéncia">
    <meta property="og:site" content="https://eloquencia.org">
    <meta property="og:title" content="Accueil">
    <meta property="og:description" content="Eloquéncia est une association loi 1901 visant à promouvoir l'éloquence et l'art oratoire">
    <title>Accueil - Eloquéncia</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <script src="js/bootstrap.bundle.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.6.0/css/all.css">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote.min.css" rel="stylesheet">
<body>
<nav class="navbar navbar-expand-lg bg-body-secondary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="assets/eloquencia_round.png" alt="Logo" width="64" height="64" class="d-inline-block">
            Administrateurs
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <div class="navbar-nav">
                <a class="nav-link" href="./">Accueil</a>
                <a class="nav-link" href="lessons">Leçons</a>
                <a class="nav-link" href="discount">Remises</a>
                <a class="nav-link" href="contact">Contact</a>
                <a class="nav-link" href="logout">Déconnexion</a>
            </div>
        </div>
    </div>
</nav>
<div class="container">
    <div class="row">
        <div class="col-12 text-center">
            <h1 class="display-1 ">Modifier un chapitre</h1>
            <a href="lessons" class="btn btn-secondary">Retour</a>
        </div>
    </div>
    <div class="row mt-4 d-flex justify-content-center">
        <form method="post">
           <div class="mb-3">
               <label for="title" class="form-label">Titre</label>
               <input type="text" class="form-control" id="title" required name="title" value="<?= $chapter['name']; ?>">
           </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <input type="text" class="form-control" id="description" required name="description" value="<?= $chapter['description']; ?>">
            </div>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="fas fa-arrow-left"></i> Annuler</button>
                <button type="submit" class="btn btn-success" name="submit">Enregistrer</button>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="deleteModalBody">
                Êtes-vous sûr de vouloir quitter sans enregistrer ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <a href="lessons" class="btn btn-danger" id="deleteModalButton">Quitter</a>
            </div>
        </div>
    </div>
</div>
<footer class="bg-body-tertiary text-center text-lg-start footer mt-5 fixed-bottom">
    <div class="text-center p-3">
        © 2024 Eloquéncia | Fait avec ❤️ et hébergé en France
        <div class="text-muted">Icons by Icons8</div>
    </div>
</footer>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote.min.js"></script>
<script>
    $(document).ready(function() {
        $('#summernote').summernote();
    });
</script>
</body>
</html>