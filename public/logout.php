<?php
session_start();
$_SESSION = [];
session_destroy();
session_start();
$_SESSION['mensagem'] = 'Você saiu da sessão.';
header('Location: login.php');
exit;
?>