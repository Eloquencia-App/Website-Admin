<?php
include '../config.php';

$req = $db->prepare('SELECT * FROM lessons WHERE ID = :id');
$req->execute(array(
    'id' => $_GET['id']
));
$lesson = $req->fetch();
echo json_encode($lesson);