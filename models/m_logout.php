<?php
    // On conserve l'e-mail de l'utilisateur pour qu'il soit 
    // affiché dans le formulaire de connexion
    $tmp = $_SESSION['user']['mail'];
    session_destroy();
    session_start();

    $_SESSION['post']['mail'] = $tmp;
    redirect('login');