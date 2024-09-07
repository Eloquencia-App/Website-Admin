<?php

include 'config.php';

$req = $db->prepare('DELETE FROM tokens_admin WHERE token = ?');
$req->execute(array($_COOKIE['token_admin']));

setcookie('token_admin', '', time() - 3600, null, null, false, true);

header('Location: ./login.php?error=disconnected');