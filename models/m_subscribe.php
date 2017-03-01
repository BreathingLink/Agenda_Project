<?php
    if (isset($_SESSION['user']))
        redirect('profile');

    // Si des informations d'inscription manquent, on redirige vers login avec un message d'erreur
    if (empty($_POST['fName']) || /**empty($_POST['lName']) ||/**/ empty($_POST['mail']) || empty($_POST['pass'])) {
        $_SESSION['post'] = $_POST;

        redirect('login', 'Il manque des informations, veuillez compléter le formulaire d\'inscription.');
    }

    try {
        // On vérifie d'abord que l'email n'est pas déjà utilisé
        $stmt = $db->prepare('SELECT COUNT(*) AS dupli FROM users WHERE mail = :mail');
        $stmt->execute(array(
            ':mail' => htmlspecialchars($_POST['mail'])
        ));

        // S'il est déjà utilisé, on redirige vers login avec un message d'erreur
        if ($stmt->fetch()['dupli'])
            redirect('login', 'Cet e-mail est déjà présent dans notre base de données.');

        $stmt->closeCursor();

        // Le mail n'est pas déjà utilisé, on inscrit l'utilisateur
        $stmt = $db->prepare('INSERT INTO users (mail, password, lastName, firstName, dateInscription) VALUES (:mail, :pass, :lName, :fName, NOW())');
        $stmt->execute(array(
            ':mail' => htmlspecialchars($_POST['mail']),
            ':pass' => password_hash($_POST['pass'], PASSWORD_DEFAULT),
            ':lName' => htmlspecialchars($_POST['lName']),
            ':fName' => htmlspecialchars($_POST['fName'])
        ));

        $stmt->closeCursor();
    }
    catch (PDOException $e) {
        die($e->getMessage());
    }

    // L'utilisateur inscrit, on le connecte.
    require_once('models/m_login.php');