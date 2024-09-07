<?php

include 'config.php';
include 'Utils.php';

$utils = new Utils();

if (!$utils->checkCookie('token_admin')) {
    header('Location: login.php?error=disconnected');
}

if (isset($_GET['delete']) && isset($_GET['id'])) {
    $req = $db->prepare('DELETE FROM lessons_chapters WHERE ID = :id');
    $req->execute(array(
        'id' => $_GET['id']
    ));
    header('Location: lessons.php');
}
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
    <title>Leçons - Eloquéncia</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <script src="js/bootstrap.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.6.0/css/all.css">
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
                <a class="nav-link" href="#">Leçons</a>
                <a class="nav-link" href="discounts">Remises</a>
                <a class="nav-link" href="contact">Contact</a>
                <a class="nav-link" href="logout">Déconnexion</a>
            </div>
        </div>
    </div>
</nav>
<div class="container">
    <div class="row">
        <div class="col-12 text-center">
            <h1 class="display-1">Chapitres</h1>
            <a href="addChapter" class="btn btn-primary">Ajouter un chapitre</a>
            <a href="lessons.php" class="btn btn-secondary">Retour</a>
        </div>
    </div>
    <div class="row mt-4 d-flex justify-content-center">
        <table class="table table-striped table-hover table-responsive">
            <thead>
            <tr>
                <th>Titre</th>
                <th>Contenu</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $req = $db->prepare('SELECT ID, name, description FROM lessons_chapters');
            $req->execute();
            $chapters = $req->fetchAll();
            foreach ($chapters as $chapter) {
                ?>
                <tr>
                    <td><?= $chapter['name'] ?></td>
                    <td><?= $chapter['description'] ?></td>
                    <td>
                        <button class="btn btn-danger" onclick="deleteChapter('<?= $chapter['name']?>',<?= $chapter['ID']?>)"><i class="fas fa-trash"></i></button><a href="editChapter.php?id=<?= $chapter['ID']?>" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                    </td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</div>
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Suppression d'un chapitre</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="deleteModalBody">
                Êtes-vous sûr de vouloir supprimer le chapitre ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <a href="" class="btn btn-danger" id="deleteModalButton">Supprimer</a>
            </div>
        </div>
    </div>
</div>
<footer class="bg-body-tertiary text-center text-lg-start footer fixed-bottom">
    <div class="text-center p-3">
        © 2024 Eloquéncia | Fait avec ❤️ et hébergé en France
        <div class="text-muted">Icons by Icons8</div>
    </div>
</footer>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    function deleteChapter(title, id) {
        $('#deleteModalButton').attr('href', 'chapters.php?delete&id=' + id);
        $('#deleteModalBody').html('Êtes-vous sûr de vouloir supprimer le chapitre \"' + title + '\" ?');

        $('#deleteModal').modal('show');
    }
</script>
</body>
</html>