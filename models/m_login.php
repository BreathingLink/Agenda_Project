<?php
    // Si l'utilisateur est déjà connecté, on le redirige vers son profil
    if (isset($_SESSION['user']))
        redirect('profile');

    // Si toutes les informations sont là, on tente de récupérer les infos
    // S'il manque des informations, on ajoute un message d'erreur
    if (!empty($_POST['mail']) && !empty($_POST['pass'])) {
        try {
            $stmt = $db->prepare('SELECT * FROM users WHERE mail = :mail');
            $stmt->execute(array(
                ':mail' => htmlspecialchars($_POST['mail'])
            ));
        }
        catch (PDOException $e) {
            die($e->getMessage());
        }

        $userInfos = $stmt->fetch();
        $stmt->closeCursor();

        // S'il n'y a pas de résultats, l'utilisateur s'est trompé de mail
        // Si le mot de passe concorde avec le mail, on garde les infos et on redirige vers le profil
        // Sinon, le mot de passe est incorrect et on affiche un message d'erreur
        if (empty($userInfos))
            $_SESSION['errors'][] = 'Le mail que vous avez proposé nous est inconnu.';
        elseif (password_verify($_POST['pass'], $userInfos['password'])) {
            $_SESSION['user'] = $userInfos;
            redirect('profile');
        }
        else {
            $_SESSION['errors'][] = 'Le mot de passe ne concorde pas avec le mail que vous avez proposé.';
            $_SESSION['post'] = $_POST;
        }
    }
    elseif (!empty($_POST)) {
        $_SESSION['errors'][] = 'Il manque des informations, veuillez compléter le formulaire de connexion.';
        $_SESSION['post'] = $_POST;
    }

    // Le contenu à afficher
    $title = 'Agenda - Connexion/Inscription';
    $views[] = 'login';

    function echoIfPosted($field) {
        echo (isset($_SESSION['post'][$field])) ? $_SESSION['post'][$field] : '';
    }