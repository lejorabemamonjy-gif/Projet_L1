<?php
session_start();

// supprimer toutes les variables de session
session_unset();

// détruire la session
session_destroy();

// rediriger vers l'accueil ou login
header("Location: index.php");

?>