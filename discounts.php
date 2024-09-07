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

if (isset($_GET['accept']) && isset($_GET['id'])) {
    $req = $db->prepare('UPDATE discounts SET state = 1 WHERE ID = :id');
    $req->execute(array(
        'id' => $_GET['id']
    ));
    $req = $db->prepare('SELECT email FROM discounts WHERE ID = :id');
    $req->execute(array(
        'id' => $_GET['id']
    ));
    $email = $req->fetch();
    $req = $db->prepare('SELECT code FROM discounts_codes WHERE email IS NULL');
    $req->execute();
    $code = $req->fetch();
    $req = $db->prepare('UPDATE discounts_codes SET email = :email WHERE code = :code');
    $req->execute(array(
        'email' => $email['email'],
        'code' => $code['code']
    ));
    $utils->sendValidDiscountEmail($email['email'], $code['code']);
    header('Location: discounts.php');
}

if (isset($_GET['refuse']) && isset($_GET['id'])) {
    $req = $db->prepare('UPDATE discounts SET state = 2 WHERE ID = :id');
    $req->execute(array(
        'id' => $_GET['id']
    ));
    $req = $db->prepare('SELECT email FROM discounts WHERE ID = :id');
    $req->execute(array(
        'id' => $_GET['id']
    ));
    $email = $req->fetch();
    $utils->sendInvalidDiscountEmail($email['email']);
    header('Location: discounts.php');
}

if (isset($_GET['proof']) && isset($_GET['id'])) {
    $data = $utils->getProof($_GET['id']);
    echo $data;
    exit();
}

if (isset($_POST['code'])) {
    $req = $db->prepare('INSERT INTO discounts_codes (code) VALUES (:code)');
    $req->execute(array(
        'code' => htmlspecialchars($_POST['code'])
    ));
    header('Location: discounts.php');
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
                <a class="nav-link" href="#">Remises</a>
                <a class="nav-link" href="contact">Contact</a>
            </div>
        </div>
    </div>
</nav>
<div class="container">
    <div class="row">
        <div class="col-12 text-center">
            <h1 class="display-1">Réductions</h1>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDiscount">Ajouter un code de réduction</button>
            <?php
            if (!$utils->checkDiscountAvailable()) {
                ?>
                <div class="alert alert-warning" role="alert">
                    Il n'y a plus de codes de réduction disponibles
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <div class="row mt-4 d-flex justify-content-center">
        <table class="table table-striped table-hover table-responsive">
            <thead>
            <tr>
                <th>Demandeur</th>
                <th>Adresse mail</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $req = $db->prepare('SELECT ID, name, email, state FROM discounts WHERE state = 0');
            $req->execute();
            $requests = $req->fetchAll();
            foreach ($requests as $request) {
                ?>
                <tr>
                    <td><?= $request['name'] ?></td>
                    <td><?= $request['email'] ?></td>
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
                <h5 class="modal-title" id="requestModalLabel">Demande de XXX </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="requestModalBody">
                <div id="requestModalProof"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <a href="" class="btn btn-danger" id="refuseModalButton">Refuser</a>
                <a href="" class="btn btn-success" id="confirmModalButton">Valider</a>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="addDiscount" tabindex="-1" aria-labelledby="addDiscountLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDiscountLabel">Ajouter un code de réduction </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post">
                <div class="modal-body" id="ModalBody">
                    <div class="mb-3">
                        <label for="code" class="form-label">Code</label>
                        <input type="text" class="form-control" id="code" name="code" required maxlength="10">
                        <small id="codeHelp" class="form-text text-muted">Le code doit être unique et ne pas dépasser 10 caractères. Pensez à l'enregistrer dans HelloAsso !</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </div>
                </form>
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
            url: 'discounts.php?proof&id=' + id,
            type: 'GET',
            success: function (data) {
                $('#requestModalProof').html('<img src="data:image/png;base64,' + data + '" class="img-fluid">');
            }
        });
        $('#confirmModalButton').attr('href', 'discounts.php?accept&id=' + id);
        $('#refuseModalButton').attr('href', 'discounts.php?refuse&id=' + id);
        $('#requestModalLabel').html('Demande de ' + name);

        $('#requestModal').modal('show');
    }

</script>
</body>
</html>