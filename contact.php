<?php

include 'config.php';
include 'Utils.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$utils = new Utils();

if (!$utils->checkCookie('token_admin')) {
    header('Location: login.php?error=disconnected');
}

if (isset($_GET['delete']) && isset($_GET['id'])) {
    $req = $db->prepare('DELETE FROM contact WHERE ID = :id');
    $req->execute(array(
        'id' => htmlspecialchars($_GET['id'])
    ));
    header('Location: contact.php');
}


if (isset($_GET['message']) && isset($_GET['id'])) {
    $data = $utils->getMessage(htmlspecialchars($_GET['id']));
    echo $data;
    exit();
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
    <title>Réductions - Eloquéncia</title>
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
                <a class="nav-link" href="lessons">Leçons</a>
                <a class="nav-link" href="discounts">Remises</a>
                <a class="nav-link" href="#">Contact</a>
            </div>
        </div>
    </div>
</nav>
<div class="container">
    <div class="row">
        <div class="col-12 text-center">
            <h1 class="display-1">Contact</h1>
        </div>
    </div>
    <div class="row mt-4 d-flex justify-content-center">
        <table class="table table-striped table-hover table-responsive">
            <thead>
            <tr>
                <th>Demandeur</th>
                <th>Adresse mail</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $req = $db->prepare('SELECT ID, name, email, datetime FROM contact');
            $req->execute();
            $requests = $req->fetchAll();
            foreach ($requests as $request) {
                $request['datetime'] = date('d/m/Y H:i', strtotime($request['datetime']));
                ?>
                <tr>
                    <td><?= $request['name'] ?></td>
                    <td><?= $request['email'] ?></td>
                    <td><?= $request['datetime'] ?></td>
                    <td>
                        <button class="btn btn-primary" onclick="showRequest('<?= $request['name']?>', '<?= $request['email']?>', '<?= $request['ID']?>')"><i class="fas fa-eye"></i></button>
                    </td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</div>
<div class="modal fade" id="requestModal" tabindex="-1" aria-labelledby="requestModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="requestModalLabel">Message de </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="requestModalBody">
                <div id="requestModalMessage"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <a href="" class="btn btn-danger" id="refuseModalButton">Supprimer</a>
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
    function showRequest(name, email, id) {
        $.ajax({
            url: 'contact.php?message&id=' + id,
            type: 'GET',
            success: function (data) {
                $('#requestModalMessage').html('<p>' + data + '</p>');
            }
        });
        $('#refuseModalButton').attr('href', 'contact.php?delete&id=' + id);
        $('#requestModalLabel').html('Demande de ' + name);

        $('#requestModal').modal('show');
    }

</script>
</body>
</html>