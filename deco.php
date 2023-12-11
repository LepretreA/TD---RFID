<?php
// Détruire la session existante pour déconnecter l'utilisateur
session_start();
session_destroy();

// Rediriger l'utilisateur vers la page d'accueil ou une autre page après la déconnexion
header("Location: index.php"); // Remplacez "index.php" par la page de votre choix
exit;
?>
