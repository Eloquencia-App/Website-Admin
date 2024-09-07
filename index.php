<?php

include 'config.php';
include 'Utils.php';

$utils = new Utils();

if (!$utils->checkCookie('token_admin')) {
    header('Location: login.php?error=disconnected');
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
    <title>Accueil - Eloquéncia</title>
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
                <a class="nav-link" href="#">Accueil</a>
                <a class="nav-link" href="lessons">Leçons</a>
                <a class="nav-link" href="discounts">Remises</a>
                <a class="nav-link" href="contact">Contact</a>
            </div>
        </div>
    </div>
</nav>
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="display-1 text-center">Accueil</h1>
            <p class="lead text-center">Bienvenue sur la plateforme d'administration d'Eloquéncia</p>
        </div>
    </div>
    <div class="row mt-4 d-flex justify-content-center">
        <div class="col-3 d-flex align-items-stretch">
            <div class="card mb-3" style="max-width: 540px;">
                <div class="row g-0">
                    <div class="col-md-4 text-center">
                        <img class="img-fluid" src="https://img.icons8.com/color/100/book.png" alt="Leçons">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">Leçons</h5>
                            <p class="card-text">Gérer les leçons du site et de l'application</p>
                            <a href="lessons" class="btn btn-primary">Accéder</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-3 d-flex align-items-stretch">
            <div class="card mb-3" style="max-width: 540px;">
                <div class="row g-0">
                    <div class="col-md-4 text-center">
                        <img class="img-fluid" src="https://img.icons8.com/color/100/discount--v1.png" alt="Remises">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">Remises</h5>
                            <p class="card-text">Accéder au demande de réduction</p>
                            <a href="discounts" class="btn btn-primary">Accéder</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-3 d-flex align-items-stretch">
            <div class="card mb-3" style="max-width: 540px;">
                <div class="row g-0">
                    <div class="col-md-4 text-center">
                        <img class="img-fluid" src="https://img.icons8.com/color/100/message-group.png" alt="messages">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">Messagerie</h5>
                            <p class="card-text">Consulter les messages reçus</p>
                            <a href="messages" class="btn btn-primary">Accéder</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-3 d-flex align-items-stretch">
            <div class="card mb-3" style="max-width: 540px;">
                <div class="row g-0">
                    <div class="col-md-4 text-center">
                        <img class="img-fluid" src="https://img.icons8.com/color/100/user.png" alt="utilisateurs">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">Utilisateurs</h5>
                            <p class="card-text">Gérer les utilisateurs administrateurs</p>
                            <a href="users" class="btn btn-primary">Accéder</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4 d-flex justify-content-center">
        <div class="col-3 d-flex align-items-stretch">
            <div class="card mb-3" style="max-width: 540px;">
                <div class="row g-0">
                    <div class="col-md-4 text-center">
                        <img class="img-fluid" src="https://img.icons8.com/color/100/group.png" alt="adhérents">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">Adhérents</h5>
                            <p class="card-text">Gérer les adhérents de l'association</p>
                            <a href="subscribers" class="btn btn-primary">Accéder</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<footer class="bg-body-tertiary text-center text-lg-start footer fixed-bottom">
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
        © 2024 Eloquéncia | Fait avec ❤️ et hébergé en France
        <div class="text-muted">Icons by Icons8</div>
    </div>
</footer>
</body>
</html>