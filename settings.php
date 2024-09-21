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

if (isset($_GET['loadLMSAnnouncement'])) {
    $announcement = $utils->getLMSAnnouncement();
    echo $announcement;
    exit();
}

if (isset($_POST['titleLMS']) && isset($_POST['editorLMS'])) {
    if (isset($_POST['stateLMS'])) {
        $state = 1;
    } else {
        $state = 0;
    }
    $utils->setLMSAnnouncement(htmlspecialchars($_POST['titleLMS']), htmlspecialchars($_POST['editorLMS']), $state);
    header('Location: settings.php');
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
    <title>Paramètres - Eloquéncia</title>
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
            <h1 class="display-1">Paramètres</h1>
        </div>
    </div>
    <div class="row mt-4 d-flex justify-content-center">
        <div class="col-6 d-flex align-items-stretch">
            <div class="card mb-3">
                <div class="row g-0">
                    <div class="col-md-4 text-center">
                        <img class="img-fluid" src="https://img.icons8.com/color/100/book.png" alt="Leçons">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">Annonce LMS</h5>
                            <p class="card-text">Gérer l'annonce LMS</p>
                            <button class="btn btn-primary" onclick="loadAnnouncement()">Modifier</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="lmsAnnouncementModal" tabindex="-1" aria-labelledby="lmsAnnouncementModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="lmsAnnouncementModalLabel">Annonce LMS</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="lmsAnnouncementModalBody">
                    <div class="form-group">
                        <label for="lmsAnnouncementTitle">Titre</label>
                        <input type="text" class="form-control" id="lmsAnnouncementTitle" name="titleLMS">
                    </div>
                    <div class="form-group">
                        <label for="summernote">Contenu</label>
                        <textarea id="summernote" name="editorLMS"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="lmsAnnouncementState">Activer</label>
                        <input type="checkbox" class="form-check-input" id="lmsAnnouncementState" name="stateLMS">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-success">Enregistrer</button>
                </div>
            </form>
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
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote.min.js"></script>
<script>
    $(document).ready(function() {
        $('#summernote').summernote();
    });
</script>
<script>
    function loadAnnouncement() {
        $.get('settings.php?loadLMSAnnouncement', function (data) {
            let announcement = JSON.parse(data);
            $('#lmsAnnouncementTitle').val(announcement.value.title);
            $('#summernote').summernote('code', announcement.value.content);
            if (announcement.state === 1) {
                $('#lmsAnnouncementState').prop('checked', true);
            } else {
                $('#lmsAnnouncementState').prop('checked', false);
            }
        });
        $('#lmsAnnouncementModal').modal('show');
    }
</script>
</body>
</html>