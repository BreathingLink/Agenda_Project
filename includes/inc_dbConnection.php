<?php
    // Tente une connexion à la base de données, traite les erreurs SQL en
    // erreurs PHP et ressort les données dans un tableau associatif
    try {
        $pdo_options[PDO::MYSQL_ATTR_INIT_COMMAND] = "SET NAMES utf8";
        $db = new PDO('mysql:dbname=db_agenda;host=localhost', 'root', '', $pdo_options);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }
    catch (PDOException $e) {
        die($e->getMessage());
    }